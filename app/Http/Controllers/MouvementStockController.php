<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Emplacement;
use App\Models\Materiel;
use Illuminate\Http\Request;
use App\Models\MouvementStock;

class MouvementStockController extends Controller
{
    public function listMouvement($id_emplacement,$role)
    {
        if($role=='Super Admin' OR $role=='Admin IT'){
$mouvement = MouvementStock::with('utilisateurs')->get();
        }else{
$mouvement = MouvementStock::with('utilisateurs')->where('emplacement_destination',$id_emplacement)->get();

        }
        
        //  dd($mouvement);
        $detail_mouvements = $mouvement->flatMap(function ($mouvement) {

            if ($mouvement->utilisateurs->isEmpty()) {
                if ($mouvement->type_mouvement == 'entree') {
                    $emplacementMateriel = Emplacement::where('id', $mouvement->emplacement_destination)->get()->first();
                    // dd($emplacementMateriel);
                    $destination = $emplacementMateriel->emplacement;
                    $source = $mouvement->source;
                } else {
                    $destination = $mouvement->utilisateur_destination;
                    //  dd($utilisateur_destination);
                    $emplacementMateriel = Emplacement::where('id', $mouvement->source)->get()->first();

                    $source = $emplacementMateriel->emplacement;
                    // dd($source);
                }
                $materiel = Materiel::where('id', $mouvement->id_materiel)->get()->first();
                $model_materiel = $materiel->model;
                $type_materiel = $materiel->type;
                $image_materiel = $materiel->image;
                return [[
                    'id' => $mouvement->id,
                    'type_mouvement' => $mouvement->type_mouvement,
                    'quantite' => $mouvement->quantite,
                    'id_materiel' => $mouvement->id_materiel,
                    'model' => $model_materiel,
                    'type' => $type_materiel,
                    'image' => $image_materiel,
                    'source' => $source,
                    'destination' => $destination,
                    'date_mouvement' => $mouvement->created_at,

                    'nom_utilisateur' => '-',
                    'prenom_utilisateur' => '-',
                    'email' => '-',
                ]];
            }

            return $mouvement->utilisateurs->map(function ($user) use ($mouvement) {
                if ($mouvement->type_mouvement == 'entree') {
                    $emplacementMateriel = Emplacement::where('id', $mouvement->emplacement_destination)->get()->first();
                    $destination = $emplacementMateriel->emplacement;
                    $source = $mouvement->source;
                    // dd($destination);
                } else {
                    $destination = $mouvement->utilisateur_destination;
                    //  dd($mouvement);
                    $emplacementMateriel = Emplacement::where('id', $mouvement->source)->get()->first();

                    $source = $emplacementMateriel->emplacement;
                    // dd($source);
                }
                $materiel = Materiel::where('id', $mouvement->id_materiel)->get()->first();

                $model_materiel = $materiel->model;
                $type_materiel = $materiel->type;
                $image_materiel = $materiel->image;
                return [
                    'id' => $mouvement->id,
                    'type_mouvement' => $mouvement->type_mouvement,
                    'quantite' => $mouvement->quantite,
                    'id_materiel' => $mouvement->id_materiel,
                    'model' => $model_materiel,
                    'type' => $type_materiel,
                    'image' => $image_materiel,
                    'source' => $source,
                    'destination' => $destination,
                    'date_mouvement' => $mouvement->created_at,

                    'nom_utilisateur' => $user->nom_utilisateur,
                    'prenom_utilisateur' => $user->prenom_utilisateur,
                    'email' => $user->email,
                ];
            });
        });

        $mouvement = $detail_mouvements;
        // dd($mouvement);
        $active_tab='stock';
        return view('mouvement_stock.liste', compact('mouvement','active_tab'));
    }
    static function CreatMouvementStock(MouvementStock $mouvement){
                    MouvementStock::create([
                'id_materiel' => $mouvement->id_materiel,
                'type_mouvement' => $mouvement->type_mouvement,
                'source' => $mouvement->source,
                'emplacement_destination' => $mouvement->emplacment_destination,
                'utilisateur_destination' => $mouvement->utilisateur_destination,

            ]);
    }
}
