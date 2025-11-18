<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Emplacement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Http\Controllers;
class EmplacementController extends Controller
{
    public function listeEmplacement()
    {
        $emplacement = Emplacement::all();
        $active_tab = 'emplacement';
        return view('emplacement.liste', compact('emplacement','active_tab'));
    }

    public function ajouterEmplacement(Request $data)
    {
        $this->validate($data, [
            'code_emplacement' => 'required',
            'emplacement' => 'required',
            // 'code_final' => 'required',
        ]);

        Emplacement::create([
            'code_emplacement' => $data['code_emplacement'],
            'emplacement' => $data['emplacement'],
            // 'code_final' => $data['code_final'],
        ]);
        $notification = 'Emplacement ajouté avec succès';
        $emplacement = Emplacement::all();
        $active_tab = 'emplacement';
        return view('emplacement.liste', compact('emplacement', 'notification','active_tab'));
    }
    public function getMateriels($id_emplacement)
    {

        $materiel = Materiel::with('caracteristiques')->where('id_emplacement', $id_emplacement)->get();
        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = $materiel->flatMap(function ($materiel) use ($colonnes) {
            $caracts = $materiel->caracteristiques->pluck('valeur', 'cle')->toArray();

            // Si aucun utilisateur, on retourne au moins une ligne avec des champs vides
            if ($materiel->utilisateurs->isEmpty()) {
                $emplacementMateriel = Emplacement::where('id', $materiel->id_emplacement)->get()->first();
                $base = [
                    'id' => $materiel->id,
                    'image' => $materiel->image,
                    'id_emplacement' => $materiel->id_emplacement,
                    'emplacement' => $emplacementMateriel->emplacement,
                    'id_utilisateur' => $materiel->id_utilisateur,
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
                    'emplacement' => $emplacementMateriel->emplacement,
                    'id_utilisateur' => $materiel->id_utilisateur,
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

        $materiel = $detail_materiel;
        // dd($materiel);
        $active_tab = 'emplacement';
        return view('localisation.localisation', compact('materiel','active_tab'));
    }

    public function detailsEmplacement($id)
    {
        $emplacement = Emplacement::where('id', $id)->get()->first();
        $nbrmateriels = Materiel::where('id_emplacement', $id)
                        ->select('type', DB::raw('COUNT(*) as total'))
                        ->groupBy('type')
                        ->get();
        $nbrutilisateurs = User::where('id_emplacement', $id)->count();
        // dd($emplacement->id);
        $active_tab = 'emplacement';
        return view('emplacement.details', compact('emplacement','active_tab', 'nbrmateriels', 'nbrutilisateurs'));
    }

    public function editEmplacement($id)
    {
        $emplacement = Emplacement::where('id', $id)->get()->first();
        // dd($emplacement->id);
        $active_tab = 'emplacement';
        return view('emplacement.modifier', compact('emplacement','active_tab'));
    }
    public function modifierEmplacement(Request $request)
    {
        $this->validate($request, [
            'idemplacement' => 'required',
            'code_emplacement' => 'required',
            'emplacement' => 'required',
            // 'code_final' => 'required',
        ]);
        $id = $request['idemplacement'];
        $emplacementData = $request->all();
        Emplacement::find($id)->update($emplacementData);
        $notification = 'Emplacement modifié avec succès';
        $emplacement = Emplacement::all();
        $active_tab = 'emplacement';
        return view('emplacement.liste', compact('emplacement', 'notification','active_tab'));
    }
    //     protected function delete(Emplacement $id)
    // {
    //     dd($id);
    //     $id->delete();
    //     $notification='Emplacement supprimé avec succès';
    //     $emplacement = Emplacement::all();
    //     return view('emplacement.liste',compact('emplacement','notification'));
    // }
    public function delete(Request $request, Emplacement $id)
    {
        if ($request->ajax()) {
            try {
                $id->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Emplacement supprimé avec succès.',
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
}
