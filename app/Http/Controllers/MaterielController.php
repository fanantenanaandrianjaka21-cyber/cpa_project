<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Materiel;
use App\Models\Affectation;
use App\Models\Alertes_types;
use App\Models\Emplacement;
use App\Models\TypeMateriel;
use Illuminate\Http\Request;
use App\Models\MouvementStock;
use App\Models\CategorieMateriel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CaracteristiqueSupplementaire;

class MaterielController extends Controller
{
    static function recupererColonnes($nomtable, $nomcolonne)
    {
        $colonnes = DB::table($nomtable)
            ->select($nomcolonne, DB::raw('MIN(id) as first_id'))
            ->groupBy($nomcolonne)
            ->orderBy('first_id')
            ->pluck($nomcolonne)
            ->toArray();
        return $colonnes;
    }
    static function recupererLesInfoMateriels($materiel, $colonnes)
    {
        // Transformer les données en tableau avec clés dynamiques
        $detail_materiel = $materiel->flatMap(function ($materiel) use ($colonnes) {
            $caracts = $materiel->caracteristiques->pluck('valeur', 'cle')->toArray();
            // Si aucun utilisateur, on retourne au moins une ligne avec des champs vides
            if ($materiel->utilisateurs->isEmpty()) {
                $emplacementMateriel = Emplacement::where('id', $materiel->id_emplacement)->get()->first();
                $base = [
                    'id' => $materiel->id,
                    'image' => $materiel->image,
                    'id_emplacement' => $materiel->id_emplacement,
                    'code_locale' => $emplacementMateriel->code_emplacement,
                    'emplacement' => $emplacementMateriel->emplacement,
                    // 'code_final' => $emplacementMateriel->code_final,
                    'id_utilisateur' => $materiel->id_utilisateur,
                    'code_interne' => $materiel->code_interne,
                    'date_aquisition' => $materiel->date_aquisition,
                    'type' => $materiel->type,
                    'quantite' => $materiel->quantite,
                    'marque' => $materiel->marque,
                    'model' => $materiel->model,
                    'num_serie' => $materiel->num_serie,
                    'status' => $materiel->status,
                ];

                foreach ($colonnes as $key) {
                    $base[$key] = $caracts[$key] ?? '-';
                }

                // Ajout champs utilisateur vides
                $base['id_user'] = null;
                $base['nom_utilisateur'] = '-';
                $base['prenom_utilisateur'] = '-';
                $base['email'] = '-';
                $base['societe'] = '-';
                $base['equipe'] = '-';

                return [$base]; // Toujours un tableau
            }

            // Sinon, dupliquer le matériel pour chaque utilisateur
            return $materiel->utilisateurs->map(function ($user) use ($materiel, $caracts, $colonnes) {
                $emplacementMateriel = Emplacement::where('id', $materiel->id_emplacement)->get()->first();
                $base = [
                    'id' => $materiel->id,
                    'image' => $materiel->image,
                    'id_emplacement' => $materiel->id_emplacement,
                    'code_locale' => $emplacementMateriel->code_emplacement,
                    'emplacement' => $emplacementMateriel->emplacement,
                    // 'code_final' => $emplacementMateriel->code_final,
                    'id_utilisateur' => $materiel->id_utilisateur,
                    'code_interne' => $materiel->code_interne,
                    'date_aquisition' => $materiel->date_aquisition,
                    'type' => $materiel->type,
                    'marque' => $materiel->marque,
                    'model' => $materiel->model,
                    'num_serie' => $materiel->num_serie,
                    'status' => $materiel->status,
                ];

                foreach ($colonnes as $key) {
                    $base[$key] = $caracts[$key] ?? '-';
                }

                // Ajout des infos utilisateur directement
                $base['id_user'] = $user->id;
                $base['nom_utilisateur'] = $user->nom_utilisateur;
                $base['prenom_utilisateur'] = $user->prenom_utilisateur;
                $base['email'] = $user->email;
                $base['societe'] = $user->societe;
                $base['equipe'] = $user->equipe;

                return $base;
            });
        });
        return $detail_materiel;
    }
    public function index($id_emplacement, $role)
    {
        if ($role == 'Super Admin' or $role == 'Admin IT') {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'disponible')->get();
        } else {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'disponible')->where('id_emplacement', $id_emplacement)->get();
        }
        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);

        $materielpartype = collect($detail_materiel)
            ->groupBy('type')
            ->map(function ($materiel) {
                $materielemplacement = collect($materiel)
                    ->where('type', $materiel[0]['type'])->where('emplacement', '!=', 'GLOBALE')
                    ->groupBy('emplacement')
                    ->map(function ($emplacement) {
                        // dd($emplacement);
                        // dd($emplacement->sum('quantite'));
                        return [
                            'id_emplacement' => $emplacement[0]['id_emplacement'],
                            'nom_emplacement' => $emplacement[0]['emplacement'],
                            // 'quantite' => $emplacement->count(),
                            'quantite' => $emplacement->sum('quantite'),
                            'emplacement' => $emplacement,
                        ];
                    })
                    ->values();
                // IL FAUT METTRE GLOBALE
                $non_distribue = $materiel->where('emplacement', 'GLOBALE')->sum('quantite');
                $Total_en_stock = $materiel->where('emplacement', '!=', 'GLOBALE')->sum('quantite');
                // dd($non_distribue);
                return [
                    'materielemplacement' => $materielemplacement,
                    'type' => $materiel[0]['type'],
                    'non_distribue' => $non_distribue,
                    'quantite' => $Total_en_stock,
                    'materiel' => $materiel,
                ];
            })
            ->values();
        // dd($materielpartype);
        $emplacement = Emplacement::all();
        $emplacement1 = $emplacement;
        // $alert = Alert::where('id', 1)->get()->first();
        // $alert=Alert::All();
        $alert = Alertes_types::All();
        // dd($alert);
        $active_tab = 'stock';
        return view('materiel.gestion', compact('materielpartype', 'emplacement', 'colonnes', 'i', 'active_tab', 'alert', 'emplacement1'));
    }
    public function afficheMateriels($id_emplacement, $role)
    {
        if ($role == 'Super Admin' or $role == 'Admin IT') {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('categorie','poste')->get();
            // dd($materiel);
        } else {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('id_emplacement', $id_emplacement)->where('id_utilisateur', Auth::user()->id)->get();
        }

        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);

        $emplacement = Emplacement::all();
        $active_tab = 'materiel';
        return view('materiel.liste', compact('detail_materiel', 'emplacement', 'colonnes', 'i', 'active_tab'));
    }
        public function afficheConsommable($id_emplacement, $role)
    {
        if ($role == 'Super Admin' or $role == 'Admin IT') {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('categorie','consommable')->get();
            // dd($materiel);
        } else {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('id_emplacement', $id_emplacement)->where('id_utilisateur', Auth::user()->id)->get();
        }

        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);

        $emplacement = Emplacement::all();
        $active_tab = 'materiel';
        return view('materiel.liste', compact('detail_materiel', 'emplacement', 'colonnes', 'i', 'active_tab'));
    }
    
    public function afficheMaterielspartype_centre($type)
    {
        if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT') {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('type', $type)->where('status', 'disponible')->get();
        } else {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('type', $type)->where('status', 'disponible')->where('id_emplacement', Auth::User()->id_emplacement)->get();
        }

        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
        $emplacement = Emplacement::all();
        $active_tab = 'stock';
        return view('materiel.liste', compact('detail_materiel', 'emplacement', 'colonnes', 'i', 'active_tab'));
    }
    public function afficheMaterielspartype_par_centre($type, $id_emplacement)
    {
        // dd($id_emplacement);
        if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT') {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('type', $type)->where('status', 'disponible')->where('id_emplacement', $id_emplacement)->get();
        } else {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('type', $type)->where('status', 'disponible')->where('id_emplacement', Auth::User()->id_emplacement)->get();
        }

        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
        $emplacement = Emplacement::all();
        $active_tab = 'stock';
        return view('materiel.liste', compact('detail_materiel', 'emplacement', 'colonnes', 'i', 'active_tab'));
    }

    private function ajoutPhoto(Materiel $materiel)
    {
        // si une image est recu
        if (request('image')) {
            return $materiel->update([
                'image' => request('image')->store('imageMateriel', 'public')
            ]);
        }
    }
    public function ajoutMateriel(Request $request)
    {

        $this->validate($request, [
            'id_emplacement' => 'required',
            'id_utilisateur' => 'nullable',
            'code_interne' => 'nullable',
            'type' => 'required',
            'quantite' => 'required',
            'nbr_poste' => 'nullable',
            'categorie' => 'required',
            'marque' => 'nullable',
            'model' => 'nullable',
            'num_serie' => 'nullable',
            'status' => 'required',
            'image' => 'nullable',
            'date_aquisition' => 'required',
        ]);


        // dd($request['categorie']);
        // $notification = [];

        $nombreAjout = $request['quantite'];
        for ($i = 0; $i < $nombreAjout; $i++) {

            $objetMateriel = Materiel::create([
                'id_emplacement' => $request['id_emplacement'],
                // 'code_interne' =>$code_interne ,
                'type' => $request['type'],
                'categorie' => $request['categorie'],
                'quantite' => 1,
                'marque' => $request['marque'],
                'model' => $request['model'],
                'num_serie' => $request['num_serie'],
                'status' => $request['status'],
                'image' => $request['image'],
                'date_aquisition' => $request['date_aquisition'],

            ]);
            $this->ajoutPhoto($objetMateriel);
            if ($i == 0) {
                $mouvementstock = new MouvementStock();
                $mouvementstock->id_materiel = $objetMateriel->id;
                $mouvementstock->type_mouvement = 'entree';
                $mouvementstock->emplacement_destination = $request['id_emplacement'];
                // dd($mouvementstock);
                //  quantiter recu a ajoute/ ajout colone quantite
                MouvementStock::create(
                    [
                        'id_materiel' => $objetMateriel->id,
                        'quantite' => $request['quantite'],
                        'type_mouvement' => 'entree',
                        'emplacement_destination' => $request['id_emplacement'],

                    ]
                );
            }
            // on ajout quantite utiliser egale  0 au debut where id= id materiel 
            $affectation = Affectation::create([
                'id_materiel' => $objetMateriel->id,
                'id_emplacement' => $request['id_emplacement'],
                'id_utilisateur' => $request['id_utilisateur'],
                'date_affectation' => $request['date_aquisition'],
            ]);
            // dd($affectation);
            // MouvementStockController::CreatMouvementStock($mouvementstock);
            $cles = $request->input('cles', []);
            $valeurs = $request->input('valeurs', []);

            foreach ($cles as $index => $cle) {

                // récupérer la valeur correspondante ou chaîne vide
                $valeur = $valeurs[$index] ?? '';
                $valeur = trim($valeur); // enlever espaces

                CaracteristiqueSupplementaire::create([
                    'id_materiel' => $objetMateriel->id,
                    'cle' => $cle,
                    'valeur' => $valeur === null ? '' : $valeur,
                ]);
            }
        }
        $notification['success'] = "Materiel ajouté avec succès";


        if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT') {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'disponible')->get();
        } else {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'disponible')->where('id_emplacement', Auth::User()->id_emplacement)->get();
        }

        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);

        $materielpartype = collect($detail_materiel)
            ->groupBy('type')
            ->map(function ($materiel) {
                $materielemplacement = collect($materiel)
                    ->where('type', $materiel[0]['type'])
                    ->groupBy('emplacement')
                    ->map(function ($emplacement) {
                        return [
                            'nom_emplacement' => $emplacement[0]['emplacement'],
                            'quantite' => $emplacement->count(),
                            'emplacement' => $emplacement,
                        ];
                    })
                    ->values();
                return [
                    'materielemplacement' => $materielemplacement,
                    'type' => $materiel[0]['type'],
                    'quantite' => $materiel->count(),
                    'materiel' => $materiel,
                ];
            })
            ->values();
        // dd('tonga');
        $emplacement = Emplacement::all();
        $active_tab = 'stock';
        // return view('materiel.gestion', compact('materielpartype', 'emplacement', 'colonnes', 'i', 'notification', 'active_tab'));
        return redirect()->route('gestionMateriels', ['id_emplacement' => Auth::user()->id_emplacement, 'role' => Auth::user()->role])->with('notification', 'Le matériel est ajouté avec succès !', 'active_tab', 'stock');
    }

    public function editMateriel($id)
    {
        // $materiel = Materiel::where('id',$id)->get()->first();
        // $emplacements=Emplacement::where('id',$materiel->id_emplacement)->get()->first();
        // $materiel['emplacement']=$emplacements->emplacement;
        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('id', $id)->get();
        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
        $emplacement = Emplacement::all();
        $materiel = $detail_materiel[0];
        $active_tab = 'stock';
        // dd($detail_materiel);
        return view('materiel.modifier', compact('materiel', 'emplacement', 'colonnes', 'active_tab'));
    }
    public function modifierMateriel(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'id_emplacement' => 'required',
            'id_utilisateur' => 'nullable',
            'type' => 'required',
            'quantite' => 'required',
            'marque' => 'nullable',
            'model' => 'nullable',
            'num_serie' => 'nullable',
            'status' => 'required',
            'image' => 'nullable',
            'date_aquisition' => 'required',
        ]);
        $id = $request['idmateriel'];
        //  dd($id);
        $materielData = $request->all();

        $materielData = $request->except('image');
        Materiel::find($id)->update($materielData);
        if (request('image')) {
            Materiel::find($id)->update([
                'image' => request('image')->store('imageMateriel', 'public')
            ]);
        }
        // $keys = array_keys($materielData); // récupère toutes les clés
        // dd($keys[4]);
        //   $taille=count($materielData);
        //   dd($taille);
        // $caracteristique = CaracteristiqueSupplementaire::where('id_materiel',$id)->get();

        // for($i=0;$i<$taille;$i++){
        //          foreach($caracteristique as $caracteristique){
        //         $caracteristique_modifier=CaracteristiqueSupplementaire::findOrFail($caracteristique->id);
        //         // $caracteristique_modifier->$keys[$i];
        //         $caracteristique_modifier->save();
        //     }

        // }
        //     dd($caracteristique);

        return redirect()->route('materiel.partype_centre', ['type' => $request['type']])->with('notification', 'Le matériel a été modifié avec succès !');
    }
    //     protected function delete(Materiel $id)
    //     {
    //         $id->delete();

    //         $materiel = Materiel::with('caracteristiques', 'utilisateurs')->get();
    //         $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
    //         $i = $colonnes;
    //         $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
    //         $materielpartype = collect($detail_materiel)
    //             ->groupBy('type')
    //             ->map(function ($materiel) {
    //                 return [
    //                     'type' => $materiel[0]['type'],
    //                     'quantite' => $materiel->count(),
    //                     'materiel' => $materiel // si tu veux garder la liste des matériels
    //                 ];
    //             })
    //             ->values();
    //         $notification = 'Materiel supprimé avec succès';
    // $active_tab='stock';
    //         return view('materiel.gestion', compact('materielpartype', 'notification','active_tab'));
    //     }

    public function delete(Request $request, Materiel $id)
    {
        if ($request->ajax()) {
            try {
                $id->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Materiel supprimé avec succès.',
                    'id' => $id->id
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression.',
                    'error' => $e->getMessage()
                ], 500);
            }
        }

        // Si ce n'est pas une requête AJAX
        abort(403, 'Requête non autorisée.');
    }
    public function distribuer(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'id_emplacement' => 'required|integer',
        ]);

        try {
            // ✅ Filtrer uniquement les IDs numériques (on enlève 'tous' ou autres valeurs non numériques)
            $idsValides = array_filter($request->ids, fn($id) => is_numeric($id));

            if (!empty($idsValides)) {
                // ✅ Mettre à jour tous les matériels sélectionnés
                Materiel::whereIn('id', $idsValides)->update([
                    'id_emplacement' => $request->id_emplacement,
                ]);

                // ✅ Enregistrer un mouvement global pour la distribution
                MouvementStock::create([
                    // Ici, tu peux enregistrer le premier ID ou un champ symbolique
                    'id_materiel' => $idsValides[0], // facultatif, selon ton modèle
                    'quantite' => count($idsValides),
                    'type_mouvement' => 'entree',
                    'source' => 'GLOBALE',
                    'emplacement_destination' => $request->id_emplacement,
                ]);
            }

            return response()->json(['message' => 'Mise à jour réussie.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur : ' . $e->getMessage()], 500);
        }
    }
}
