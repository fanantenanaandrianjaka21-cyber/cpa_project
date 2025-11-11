<?php

namespace App\Http\Controllers;

use App\Models\Affectation;
use App\Models\Emplacement;
use App\Models\Materiel;
use App\Models\MouvementStock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffectationController extends Controller
{
    static function recupererLesinfoAffectation()
    {
        if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT') {
            $affectation = affectation::with('materiels', 'utilisateurs')->get();
        } else {
            $affectation = affectation::with('materiels', 'utilisateurs')->where('id_emplacement', Auth::User()->id_emplacement)->get();
        }


        $detail_affectations = $affectation->flatMap(function ($affectation) {

            if ($affectation->materiels->isEmpty()) {
                $materiel = Materiel::where('id', $affectation->id_materiel)->get()->first();
                $model_materiel = $materiel->model;
                $image_materiel = $materiel->image;
                $type_materiel = $materiel->type;
                $emplacement = Emplacement::where('id', $affectation->id_emplacement)->get()->first();
                $emplacement = $emplacement->emplacement;
                return [[
                    'id' => $affectation->id,
                    'date_affectation' => $affectation->date_affectation,
                    'id_materiel' => $affectation->id_materiel,
                    'model' => $model_materiel,
                    'image' => $image_materiel,
                    'type' => $type_materiel,
                    'emplacement' => $emplacement,

                    'nom_utilisateur' => '-',
                    'prenom_utilisateur' => '-',
                    'email' => '-',
                ]];
            } elseif ($affectation->utilisateurs->isEmpty()) {
                $materiel = Materiel::where('id', $affectation->id_materiel)->get()->first();
                $model_materiel = $materiel->model;
                $image_materiel = $materiel->image;
                $type_materiel = $materiel->type;
                $emplacement = Emplacement::where('id', $affectation->id_emplacement)->get()->first();
                $emplacement = $emplacement->emplacement;
                return [[
                    'id' => $affectation->id,
                    'date_affectation' => $affectation->date_affectation,
                    'id_materiel' => $affectation->id_materiel,
                    'model' => $model_materiel,
                    'image' => $image_materiel,
                    'type' => $type_materiel,
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
                $type_materiel = $materiel->type;
                $emplacement = Emplacement::where('id', $affectation->id_emplacement)->get()->first();
                $emplacement = $emplacement->emplacement;
                return [
                    'id' => $affectation->id,
                    'date_affectation' => $affectation->date_affectation,
                    'id_materiel' => $affectation->id_materiel,
                    'model' => $model_materiel,
                    'image' => $image_materiel,
                    'type' => $type_materiel,
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
                    'type' => $utilisateur->first()['type'],
                    'model' => $utilisateur->first()['model'],
                    'nombre_affectation' => $utilisateur->count(),
                    'utilisateur' => $utilisateur
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
            // 'id_emplacement' => 'required',
            'id_utilisateur' => 'required',
            'date_affectation' => 'required',
        ]);

        Affectation::create([
            'id_materiel' => $request['id_materiel'],
            // 'id_emplacement' => $request['id_emplacement'],
            'id_emplacement' => Auth::User()->id_emplacement,
            'id_utilisateur' => $request['id_utilisateur'],
            'date_affectation' => $request['date_affectation'],
        ]);
        $id = $request['id_materiel'];

        $selectmateriel = Materiel::where('id', $id)->get();
        if ($selectmateriel[0]->status == 'disponible') {
            $source = $selectmateriel[0]->id_emplacement;
            $selectutilisateur = User::where('id', $request['id_utilisateur'])->get()->first();
            // ajout quantite sortie 1
            MouvementStock::create([
                'id_materiel' => $id,
                'type_mouvement' => 'sortie',
                'quantite' => '1',
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




        $existe_code_interne = $selectmateriel[0]->existe_code_interne;
        // dd($existe_code_interne);
        if ($existe_code_interne == true) {
            // dd('existe code interne true');
            Materiel::find($id)->update([
                'status' => 'utiliser',
                'id_utilisateur' => $request['id_utilisateur'],
                // 'id_emplacement' => $request['id_emplacement'],
                'id_emplacement' => Auth::User()->id_emplacement,
            ]);
        } else {
            // dd('existe code interne false');
            //on test si le materiel est type poste ou consommable
            $categorie = $selectmateriel[0]->categorie;
            if ($categorie == 'poste') {
                // dd('type poste');


                // on verifie si nbr_poste_egaux !=0
                $nbr_poste = $selectmateriel[0]->nbr_poste; //a recuperer dans la base
                $type_poste = ['Accès Biostar', 'Décodeur Caméra', 'Écran plat', 'Onduleur', 'Ordinateur portable', 'Outils de communication', 'Répéteur Wi-Fi', 'Routeur', 'Stabilisateur', 'Stockage amovible', 'Switch', 'Unité centrale', 'Vidéo projecteur', 'Frigidaire', 'Imprimante'];
                $liste_code_poste = ['BIO', 'CAM', 'ECR', 'OND', 'PCP', 'COM', 'RSX', 'RSX', 'STB', 'AMV', 'RSX', 'PCB', 'COM', 'FRD', 'IMP'];
                $taille = count($type_poste);
                $type = $selectmateriel[0]->type;
                if ($nbr_poste == '0') {
                    // dd($nbr_poste);
                    for ($i = 0; $i < $taille; $i++) {
                        if ($type == $type_poste[$i]) {
                            $code_poste = $liste_code_poste[$i];
                        }
                    }



                    $marque = $selectmateriel[0]->marque;
                    $code_marque = substr($marque, 0, 2);
                    // dd($code_marque);
                    $utilisateur = User::where('id', $request['id_utilisateur'])->get()->first();
                    $matricule_utilisateur = $utilisateur->id;
                    $nombre_caractere = mb_strlen($matricule_utilisateur);
                    if ($nombre_caractere == 1) {
                        $matricule_utilisateur = '000' . $matricule_utilisateur;
                    } else if ($nombre_caractere == 2) {
                        $matricule_utilisateur = '00' . $matricule_utilisateur;
                    } else if ($nombre_caractere == 3) {
                        $matricule_utilisateur = '0' . $matricule_utilisateur;
                    }
                    // dd($matricule_utilisateur);
                    $id_emplacement = $utilisateur->id_emplacement;
                    $emplacementUtilisateur = Emplacement::where('id', $id_emplacement)->get()->first();
                    $code_locale = $emplacementUtilisateur->code_emplacement;


                    $code_interne = $code_poste . '-' . $code_marque . '-' . $matricule_utilisateur . '-' . $code_locale;
                    $existe_dans_bdd = Materiel::where('code_interne', $code_interne)->exists();
                    if ($existe_dans_bdd) {
                        $poste = Materiel::where('code_interne', $code_interne)->get()->first();
                        $nbr_poste = $poste->nbr_poste;
                        $code_poste1 = $code_poste . '' . $nbr_poste;
                        $code_interne = $code_poste1 . '-' . $code_marque . '-' . $matricule_utilisateur . '-' . $code_locale;
                        // dd($code_interne);
                        $nbr_poste = $nbr_poste + 1;

                        $existe_dans_bdd = Materiel::where('code_interne', $code_interne)->exists();
                        if ($existe_dans_bdd) {
                            $poste = Materiel::where('code_interne', $code_interne)->get()->first();
                            $nbr_poste = $poste->nbr_poste;
                            $code_poste2 = $code_poste . '' . $nbr_poste;
                            $code_interne = $code_poste2 . '-' . $code_marque . '-' . $matricule_utilisateur . '-' . $code_locale;
                            // dd($code_interne);
                            $nbr_poste = $nbr_poste + 1;
                            // ici on doit faire le meme test
                            $materiel = Materiel::find($id)->update([
                                'status' => 'utiliser',
                                'id_utilisateur' => $request['id_utilisateur'],
                                'code_interne' => $code_interne,
                                // 'id_emplacement' => $request['id_emplacement'],
                                'id_emplacement' => Auth::User()->id_emplacement,
                                'nbr_poste' => $nbr_poste,
                                'existe_code_interne' => true,
                            ]);
                        } else {
                            $materiel = Materiel::find($id)->update([
                                'status' => 'utiliser',
                                'id_utilisateur' => $request['id_utilisateur'],
                                'code_interne' => $code_interne,
                                // 'id_emplacement' => $request['id_emplacement'],
                                'id_emplacement' => Auth::User()->id_emplacement,
                                'nbr_poste' => $nbr_poste,
                                'existe_code_interne' => true,
                            ]);
                        }
                    } else {
                        $materiel = Materiel::find($id)->update([
                            'status' => 'utiliser',
                            'id_utilisateur' => $request['id_utilisateur'],
                            'code_interne' => $code_interne,
                            // 'id_emplacement' => $request['id_emplacement'],
                            'id_emplacement' => Auth::User()->id_emplacement,
                            'nbr_poste' => '1',
                            'existe_code_interne' => true,
                        ]);
                    }


                    // dd($materiel);
                } else {
                    dd('nombre poste >0');
                    $materiel = Materiel::find($id)->update([
                        'status' => 'utiliser',
                        'id_utilisateur' => $request['id_utilisateur'],
                        // 'code_interne' => 'vide',
                        // 'id_emplacement' => $request['id_emplacement'],
                        'id_emplacement' => Auth::User()->id_emplacement,
                        'nbr_poste' => '1',
                        'existe_code_interne' => true,
                    ]);
                }
            } else {
                // dd('type consommable');
                $materiel = Materiel::find($id)->update([
                    'status' => 'utiliser',
                    'id_utilisateur' => $request['id_utilisateur'],
                    // 'id_emplacement' => $request['id_emplacement'],
                    'id_emplacement' => Auth::User()->id_emplacement,
                ]);
                //    pas de code inventaire ou code interne
            }
        }



        $affectation = $this->recupererLesinfoAffectation();
        $notification = 'Materiel affecté  avec succès';
        $active_tab = 'affectation';
        return view('affectation.liste', compact('affectation', 'notification', 'active_tab'));
    }
    public function listAffectation()
    {
        $affectation = $this->recupererLesinfoAffectation();
        // dd($affectation);
        $active_tab = 'affectation';
        return view('affectation.liste', compact('affectation', 'active_tab'));
    }
    public function affectation($id)
    {
        $utilisateur = User::all();
        $emplacement = Emplacement::all();
        $active_tab = 'affectation';
        return view('affectation.ajout', compact('id', 'utilisateur', 'emplacement', 'active_tab'));
    }
    public function getUtilisateurs($id)
    {
        // récupère les utilisateurs selon l'emplacement
        $utilisateurs = User::where('id_emplacement', $id)->get();
        // dd($utilisateurs);
        return response()->json($utilisateurs);
    }
}
