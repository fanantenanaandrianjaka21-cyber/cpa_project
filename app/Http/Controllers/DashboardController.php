<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\User;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function afficheDashboard()
    {
        // --- SECTION 1 : Statistiques générales sur le parc et le stock ---
        $totalMateriels = Materiel::count();
        $repartitionType = Materiel::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')->pluck('total', 'type');
        // stock
        // $stockDispo = Materiel::sum('quantite_disponible');
        // $articlesAlerte = Materiel::whereColumn('quantite_disponible', '<=', 'seuil_minimum')->count();
        $stockDispo = 54;
        $articlesAlerte = 12;
        // ticket 
        // $ticketsOuverts = Ticket::where('statut', 'ouvert')->count();
        // $ticketsResolus = Ticket::where('statut', 'fermé')->count();
        $ticketsOuverts = 25;
        $ticketsResolus = 58;

        // --- SECTION 2 : Statistiques d’utilisation et d’affectation ---
        $materielsAffectes = Materiel::whereNotNull('id_utilisateur')->count();
        $materielsDisponibles = Materiel::whereNull('id_utilisateur')->count();

        // Répartition des matériels par service (via jointure users)
        $repartitionService = Materiel::join('users', 'materiels.id_utilisateur', '=', 'users.id')
            ->select('users.equipe', DB::raw('count(materiels.id) as total'))
            ->groupBy('users.equipe')
            ->pluck('total', 'users.equipe');

        // Moyenne de matériel par utilisateur
        $moyenneMaterielParUser = $materielsAffectes > 0 && User::count() > 0
            ? round($materielsAffectes / User::count(), 2)
            : 0;
        /*=============================
            Maintenance & Support
        ============================== */
        // $ticketsOuverts = Ticket::where('statut', 'ouvert')->count();
        // $ticketsResolus = Ticket::where('statut', 'fermé')->count();
        // $ticketsEncours = Ticket::where('statut', 'en cours')->count();

        $ticketsOuverts = 15;
        $ticketsResolus = 32;
        $ticketsEncours = 12;

        // Nombre total de tickets par priorité
        // $ticketsParPriorite = Ticket::join('laravelticket_priorities', 'tickets.priority_id', '=', 'laravelticket_priorities.id')
        //     ->select('laravelticket_priorities.name as priorite', DB::raw('count(tickets.id) as total'))
        //     ->groupBy('laravelticket_priorities.name')
        //     ->pluck('total', 'priorite');
        $ticketsParPriorite = collect([
            'Haute' => 10,
            'Moyenne' => 18,
            'Basse' => 7,
        ]);

        // Tickets par mois (tendance)
        // $ticketsParMois = Ticket::select(DB::raw("DATE_TRUNC('month', created_at) as mois"), DB::raw('count(*) as total'))
        //     ->groupBy(DB::raw("DATE_TRUNC('month', created_at)"))
        //     ->orderBy(DB::raw("DATE_TRUNC('month', created_at)"))
        //     ->pluck('total', 'mois')
        //     ->mapWithKeys(fn($v, $k) => [date('M Y', strtotime($k)) => $v]);
        // On utilise collect([...]) pour imiter une collection Larave
        $ticketsParMois = collect([
            'Jan 2025' => 8,
            'Fév 2025' => 12,
            'Mar 2025' => 5,
            'Avr 2025' => 9,
            'Mai 2025' => 7,
            'Juin 2025' => 15,
            'Juil 2025' => 10,
            'Août 2025' => 6,
            'Sep 2025' => 11,
            'Oct 2025' => 9,
        ]);

        // Taux de résolution
        $totalTickets = $ticketsOuverts + $ticketsResolus + $ticketsEncours;
        $tauxResolution = $totalTickets > 0 ? round(($ticketsResolus / $totalTickets) * 100, 2) : 0;
        $tauxPanne = 6.5; // en pourcentage
        $mttr = 4.2; // Temps moyen de réparation (heures)
        $mtbf = 120; // Temps moyen entre pannes (heures)
        // --- SECTION 4 : Statistiques prédictives et analytiques (valeurs statiques pour test) ---

        // Tendance de la demande en matériel (prévision sur 6 mois)
        $previsionDemandes = collect([
            'Nov 2025' => 15,
            'Déc 2025' => 18,
            'Jan 2026' => 22,
            'Fév 2026' => 20,
            'Mar 2026' => 25,
            'Avr 2026' => 27,
        ]);

        // Taux de panne prévisionnel (en %)
        $tauxPannePrevision = 8.5; // basé sur moyenne des 6 derniers mois

        // Durée de vie moyenne estimée par type
        $vieMoyenneParType = collect([
            'Ordinateur' => 4.2,
            'Écran' => 5.1,
            'Imprimante' => 3.7,
            'Routeur' => 6.0,
        ]);

        // Services les plus à risque de panne (analyse prédictive)
        $servicesRisque = collect([
            'CPA' => 0.75,
            'RFC' => 0.45,
            'EXPERT CPA' => 0.60,
            'BNI' => 0.85,
        ]);
        return view('dashboard.index', compact(
            'totalMateriels',
            'repartitionType',
            'stockDispo',
            'articlesAlerte',
            'materielsAffectes',
            'materielsDisponibles',
            'repartitionService',
            'moyenneMaterielParUser',
            'ticketsOuverts',
            'ticketsEncours',
            'ticketsResolus',
            'ticketsParMois',
            'ticketsParPriorite',
            'tauxPanne',
            'mttr',
            'mtbf',
            'previsionDemandes',
            'tauxResolution',
            'tauxPannePrevision',
            'vieMoyenneParType',
            'servicesRisque'
        ));
    }
    public function configurationNotification(){
   $alerte=Alert::All();
        $active_tab = 'dashboard';

        return view('dashboard.configuration_notification',compact('active_tab','alerte'));
    }
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'niveau_seuil' => 'required|numeric|min:0',
                'niveau_critique' => 'required|numeric|min:0',
            ]);

            $alerte = Alert::findOrFail($id);
            $alerte->update([
                'niveau_seuil' => $validated['niveau_seuil'],
                'niveau_critique' => $validated['niveau_critique'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Alerte mise à jour avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
