<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Materiel;
use App\Models\Affectation;
use App\Models\Emplacement;
use Illuminate\Http\Request;
use App\Models\MouvementStock;

class AffectationController extends Controller
{
    static function recupererLesinfoAffectation()
    {
        $affectation = affectation::with('materiels', 'utilisateurs')->get();
      
        $detail_affectations = $affectation->flatMap(function ($affectation) {
           
            if ($affectation->materiels->isEmpty()) {
                $materiel = Materiel::where('id', $affectation->id_materiel)->get()->first();
                $model_materiel = $materiel->model;
                $image_materiel = $materiel->image;
                $emplacement = Emplacement::where('id', $affectation->id_emplacement)->get()->first();
                $emplacement = $emplacement->emplacement;
                return [[
                    'id' => $affectation->id,
                    'date_affectation' => $affectation->date_affectation,
                    'id_materiel' => $affectation->id_materiel,
                    'model' => $model_materiel,
                    'image' => $image_materiel,
                    'emplacement' => $emplacement,

                    'nom_utilisateur' => '-',
                    'prenom_utilisateur' => '-',
                    'email' => '-',
                ]];
                
            }
elseif ($affectation->utilisateurs->isEmpty()) {
                $materiel = Materiel::where('id', $affectation->id_materiel)->get()->first();
                $model_materiel = $materiel->model;
                $image_materiel = $materiel->image;
                $emplacement = Emplacement::where('id', $affectation->id_emplacement)->get()->first();
                $emplacement = $emplacement->emplacement;
                return [[
                    'id' => $affectation->id,
                    'date_affectation' => $affectation->date_affectation,
                    'id_materiel' => $affectation->id_materiel,
                    'model' => $model_materiel,
                    'image' => $image_materiel,
                    'emplacement' => $emplacement,

                    'nom_utilisateur' => '-',
                    'prenom_utilisateur' => '-',
                    'email' => '-',
                ]];
                
            }
            return $affectation->utilisateurs->map(function ($user) use ($affectation) {
                $materiel = Materiel::where('id', $affectation->id_materiel)->get()->first();
                $model_materiel = $materiel->model;
                $image_materiel = $materiel->image;
                $emplacement = Emplacement::where('id', $affectation->id_emplacement)->get()->first();
                $emplacement = $emplacement->emplacement;
                return [
                    'id' => $affectation->id,
                    'date_affectation' => $affectation->date_affectation,
                    'id_materiel' => $affectation->id_materiel,
                    'model' => $model_materiel,
                    'image' => $image_materiel,
                    'emplacement' => $emplacement,
                    'nom_utilisateur' => $user->nom_utilisateur,
                    'prenom_utilisateur' => $user->prenom_utilisateur,
                    'email' => $user->email,
                ];
            });
        });
        $affectationparid_materiel = collect($detail_affectations)
            ->groupBy('id_materiel')
            ->map(function ($utilisateur) {
                return [
                    'id_materiel' => $utilisateur->first()['id_materiel'],
                    'image' => $utilisateur->first()['image'],
                    'model' => $utilisateur->first()['model'],
                    'nombre_affectation' => $utilisateur->count(),
                    'utilisateur' => $utilisateur // si tu veux garder la liste des matériels
                ];
            })
            ->values();
        // dd($affectationparid_materiel);
        return $affectationparid_materiel;
    }
    public function faireAffectation(Request $request)
    {
        $this->validate($request, [
            'id_materiel' => 'required',
            'id_emplacement' => 'required',
            'id_utilisateur' => 'required',
            'date_affectation' => 'required',
        ]);
        Affectation::create([
            'id_materiel' => $request['id_materiel'],
            'id_emplacement' => $request['id_emplacement'],
            'id_utilisateur' => $request['id_utilisateur'],
            'date_affectation' => $request['date_affectation'],
        ]);
        $id = $request['id_materiel'];


        $selectmateriel = Materiel::where('id', $id)->get();
        if ($selectmateriel[0]->status == 'disponible') {
            $source = $selectmateriel[0]->id_emplacement;
            $selectutilisateur = User::where('id', $request['id_utilisateur'])->get()->first();

            MouvementStock::create([
                'id_materiel' => $id,
                'type_mouvement' => 'sortie',
                'source' => $source,
                'emplacement_destination' => $selectutilisateur->id_emplacement,
                'utilisateur_destination' => $request['id_utilisateur'],

            ]);
        } else if ($selectmateriel[0]->status == 'utiliser') {
            $idUtilisateur = Affectation::where('id_materiel', $id)
                ->latest('id')
                ->value('id_utilisateur');
            // dd($idUtilisateur);
        }
        //update post data
        Materiel::find($id)->update([
            'status' => 'utiliser',
            'id_utilisateur' => $request['id_utilisateur'],
            'id_emplacement' => $request['id_emplacement'],
        ]);


        $affectation = $this->recupererLesinfoAffectation();
        $notification = 'Materiel affecté  avec succès';

        return view('affectation.liste', compact('affectation', 'notification'));
    }
    public function listAffectation()
    {
        $affectation = $this->recupererLesinfoAffectation();
        // dd($affectation);
         $active_tab='affectation';
        return view('affectation.liste', compact('affectation','active_tab'));
    }
    public function affectation($id)
    {
        $utilisateur = User::all();
        $emplacement = Emplacement::all();
         $active_tab='affectation';
        return view('affectation.ajout', compact('id', 'utilisateur', 'emplacement','active_tab'));
    }
    public function getUtilisateurs($id)
    {
        // récupère les utilisateurs selon l'emplacement
        $utilisateurs = User::where('id_emplacement', $id)->get();
        // dd($utilisateurs);
        return response()->json($utilisateurs);
    }
}
