<?php

namespace App\Http\Controllers;

use App\Models\CaracteristiqueSupplementaire;
use App\Models\Emplacement;
use App\Models\Inventaire;
use App\Models\Materiel;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class CaracteristiqueSupplementaireController extends Controller
{
    //
    public function voirCaracteristique($id, $page)
    {
        // dd($id);
        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('id', $id)->get();
        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = MaterielController::recupererLesInfoMateriels($materiel, $colonnes);
        $detail_materiel = $detail_materiel[0];
        // dd($detail_materiel);

        $emplacement = Emplacement::all();
        //  $activities = Activity::latest()->get();
        $activities = Activity::where('subject_type', Materiel::class)
            ->where('subject_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $activitie = Activity::where('subject_type', Materiel::class)
            ->where('subject_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        //    dd($activitie[0]->properties['attributes']['id_utilisateur'] ?? '-');
        //  dd($activitie[0]);
        foreach ($activitie as $index => $activitie) {

            $id_utilisateur = $activitie->properties['attributes']['id_utilisateur'] ?? '-';
            //  dd($activitie);
            if ($id_utilisateur != '-') {
                $activities[$index]->nom_utilisateur = User::where('id', $id_utilisateur)->get()->first()->nom_utilisateur;
            } else {
                $activities[$index]->nom_utilisateur = '-';
            }
        }
        //  dd($activities);
        // dd($detail_materiel['id']);
        // $utilisateur = User::all();
                $logtickets = Activity::where('subject_type', Ticket::class)
            // ->where('subject_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
            // dd($logtickets);
        $utilisateur = User::where('id_emplacement', Auth::User()->id_emplacement)->get();
        // verification inventaire physique


        $today = now();
        $startOfMonth = $today->copy()->startOfMonth();
        $endOfMonth = $today->copy()->endOfMonth();

        // Vérifier si l'inventaire existe déjà ce mois-ci
        $existing = Inventaire::where('id_materiel', $detail_materiel['id'])
            ->whereBetween('date_inventaire', [$startOfMonth, $endOfMonth])
            ->first();
        // dd($existing);
        $verification_physique = 'false';
        $observation = '';
        if ($existing) {
            $verification_physique = 'true';
            $observation = $existing->observation;
        }

        $active_tab = 'stock';
        return view('materiel.caracteristique', compact('detail_materiel', 'colonnes', 'i', 'emplacement', 'activities', 'active_tab', 'utilisateur', 'verification_physique', 'observation', 'page'));
    }
}
