<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Affectation;
use App\Models\Emplacement;
use App\Models\TypeMateriel;
use Illuminate\Http\Request;
use App\Models\MouvementStock;
use App\Models\CategorieMateriel;
use Illuminate\Support\Facades\DB;
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
                    'code_emplacement' => $emplacementMateriel->code_emplacement,
                    'emplacement' => $emplacementMateriel->emplacement,
                    'code_final' => $emplacementMateriel->code_final,
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
                    'code_emplacement' => $emplacementMateriel->code_emplacement,
                    'emplacement' => $emplacementMateriel->emplacement,
                    'code_final' => $emplacementMateriel->code_final,
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
    public function index()
    {
        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'disponible')->get();
        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);

        $materielpartype = collect($detail_materiel)
            ->groupBy('type')
            ->map(function ($materiel) {
                return [
                    'type' => $materiel[0]['type'],
                    'quantite' => $materiel->count(),
                    'materiel' => $materiel // si tu veux garder la liste des matériels
                ];
            })
            ->values(); // pour réindexer proprement

        // dd($materielpartype);
        $emplacement = Emplacement::all();
        $active_tab='stock';
        return view('materiel.gestion', compact('materielpartype', 'emplacement', 'colonnes', 'i','active_tab'));
    }
    public function afficheMateriels()
    {
        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->get();
        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
        $emplacement = Emplacement::all();
        $active_tab='materiel';
        return view('materiel.liste', compact('detail_materiel', 'emplacement', 'colonnes', 'i','active_tab'));
    }
    public function afficheMaterielspartype_centre($type)
    {
        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('type', $type)->where('status', 'disponible')->get();
        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
        $emplacement = Emplacement::all();
         $active_tab='stock';
        return view('materiel.liste', compact('detail_materiel', 'emplacement', 'colonnes', 'i','active_tab'));
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
        // dd($request);
        $this->validate($request, [
            'id_emplacement' => 'required',
            'id_utilisateur' => 'nullable',
            'code_interne' => 'required',
            'type' => 'required',
            'marque' => 'required',
            'model' => 'required',
            'num_serie' => 'required',
            'status' => 'required',
            'image' => 'sometimes|image',
            'date_aquisition' => 'required',
        ]);


        // $count = count($cles);
        $objetMateriel = Materiel::create([
            'id_emplacement' => $request['id_emplacement'],
            'code_interne' => $request['code_interne'],
            'type' => $request['type'],
            'marque' => $request['marque'],
            'model' => $request['model'],
            'num_serie' => $request['num_serie'],
            'status' => $request['status'],
            'image' => $request['image'],
            'date_aquisition' => $request['date_aquisition'],

        ]);
        $this->ajoutPhoto($objetMateriel);
        $mouvementstock = new MouvementStock();
        $mouvementstock->id_materiel = $objetMateriel->id;
        $mouvementstock->type_mouvement = 'entree';
        $mouvementstock->emplacement_destination = $request['id_emplacement'];
        // dd($mouvementstock);
        MouvementStock::create(
            [
                'id_materiel' => $objetMateriel->id,
                'type_mouvement' => 'entree',
                'emplacement_destination' => $request['id_emplacement'],

            ]
        );
        $affectation=Affectation::create([
            'id_materiel' => $objetMateriel->id,
            'id_emplacement' => $request['id_emplacement'],
            'id_utilisateur' => $request['id_utilisateur'],
            'date_affectation' => $request['date_aquisition'],
        ]);
        // dd($affectation);
        // MouvementStockController::CreatMouvementStock($mouvementstock);
        $cles = $request->input('cles');
        $valeurs = $request->input('valeurs');
        if (!empty($cles)) {
            foreach ($cles as $index => $cle) {
                CaracteristiqueSupplementaire::create([
                    'id_materiel' => $objetMateriel->id,
                    'cle' => $cles[$index],
                    'valeur' => $valeurs[$index],
                ]);
            }
        }

        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'disponible')->get();
        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
        $materielpartype = collect($detail_materiel)
            ->groupBy('type')
            ->map(function ($materiel) {
                return [
                    'type' => $materiel[0]['type'],
                    'quantite' => $materiel->count(),
                    'materiel' => $materiel // si tu veux garder la liste des matériels
                ];
            })
            ->values(); // pour réindexer proprement
        $notification = "Materiel ajouté avec succès";
        $emplacement = Emplacement::all();
        $active_tab='stock';
        return view('materiel.gestion', compact('materielpartype', 'emplacement', 'colonnes', 'i', 'notification','active_tab'));
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
        $active_tab='stock';
        // dd($detail_materiel);
        return view('materiel.modifier', compact('materiel', 'emplacement', 'colonnes','active_tab'));
    }
    public function modifierMateriel(Request $request)
    {
// dd($request);
        $this->validate($request, [
            'id_emplacement' => 'required',
            'id_utilisateur' => 'nullable',
            'type' => 'required',
            'marque' => 'required',
            'model' => 'required',
            'num_serie' => 'required',
            'status' => 'required',
            // 'image'=>'sometimes|image',
            'date_aquisition' => 'required',
        ]);
        $id = $request['idmateriel'];
        //  dd($id);
        $materielData = $request->all();
        $materielData = $request->except('image');
        //update post data
        Materiel::find($id)->update($materielData);
        // $notification = 'Materiel modifié avec succès';
        // $materiel = Materiel::with('caracteristiques', 'utilisateurs')->get();
        // $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        // $i = $colonnes;
        // $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
        // $materielpartype = collect($detail_materiel)
        //     ->groupBy('type')
        //     ->map(function ($materiel) {
        //         return [
        //             'type' => $materiel[0]['type'],
        //             'quantite' => $materiel->count(),
        //             'materiel' => $materiel // si tu veux garder la liste des matériels
        //         ];
        //     })
        //     ->values();
        // return view('materiel.gestion', compact('materielpartype', 'notification'));
       
return redirect()->route('materiel.partype_centre', ['type' => $request['type']])->with('notification', 'Le matériel a été ajouté avec succès !');

    }
    protected function delete(Materiel $id)
    {
        //dd($pub)
        $id->delete();

        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->get();
        $colonnes = $this->recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $this->recupererLesInfoMateriels($materiel, $colonnes);
        $materielpartype = collect($detail_materiel)
            ->groupBy('type')
            ->map(function ($materiel) {
                return [
                    'type' => $materiel[0]['type'],
                    'quantite' => $materiel->count(),
                    'materiel' => $materiel // si tu veux garder la liste des matériels
                ];
            })
            ->values();
        $notification = 'Materiel supprimé avec succès';
$active_tab='stock';
        return view('materiel.gestion', compact('materielpartype', 'notification','active_tab'));
    }
}
