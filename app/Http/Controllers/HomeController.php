<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Emplacement;
use App\Models\Materiel;
use App\Models\Ticket;
use App\Models\TicketPrioriteConfig;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $active_tab = 'dashboard';
        dd('welcome to dd test');
        $role = Auth::user()->role;
        $userId = Auth::id();
        if ($role == "Super Admin") {
            $total_utilisateurs = User::All()->count();
            $total_locales = Emplacement::All()->count();
            $total_materiels = Materiel::All()->sum('quantite');
            $total_tickets = Ticket::All()->count();
            $materiels_affecte = Materiel::where('status', 'utiliser')->get()->sum('quantite');
            $materiels_disponible = Materiel::where('status', 'disponible')->get()->sum('quantite');
            if ($materiels_affecte != 0) {
                $taux_utilisation_stock = ($materiels_affecte / $total_materiels) * 100;
                $taux_utilisation_stock=round($taux_utilisation_stock, 2);
            } else if ($materiels_disponible != 0 and $materiels_affecte == 0) {
                $taux_utilisation_stock = 0;
            } else {
                $taux_utilisation_stock = '-';
            }
            $alert=Alert::where('id', 1)->get()->first();
            $emplacement = Emplacement::all();
     $utilisateur = User::orderBy('id', 'desc')->first();
            return view('dashboard.super_admin', compact('emplacement','utilisateur',
            'active_tab','alert', 'total_utilisateurs', 'total_locales', 'total_materiels', 'total_tickets', 'taux_utilisation_stock'));
        } elseif ($role == "Admin IT") {
            return view('home', compact('active_tab'));
        } elseif ($role == "Responsable Site") {
            return view('home', compact('active_tab'));
        } elseif ($role == "Technicien IT") {
                    $userId = Auth::id(); // ID de l'utilisateur connecté
        $materiels = Materiel::all();
        $users = User::all();

        // $tickets = DB::table('tickets')
        //     ->join('users', 'users.id', '=', 'tickets.id_utilisateur')
        //     ->join('materiels', 'materiels.id', '=', 'tickets.id_materiel')
        //     ->select(
        //         'tickets.id',
        //         'tickets.objet',
        //         'tickets.priorite',
        //         'tickets.description',
        //         'tickets.assignement',
        //         'tickets.statut',
        //         'tickets.created_at',
        //         'users.prenom_utilisateur as utilisateur',
        //         'materiels.type as type'
        //     )
        //     ->where('tickets.assignement', $userId)
        //     ->get();
                   $tickets = Ticket::with(['utilisateur', 'materiel'])
                ->where('assignement', $userId)
                ->get();
// dd($tickets );
     return view('ticketing.technicien.liste', compact('tickets', 'materiels', 'users'));
        } else {
            $materiels = Materiel::all();
            $users = User::all();
            // $dernierTickets = DB::table('tickets')
            // ->join('materiels', 'materiels.id', '=', 'tickets.id_materiel')
            // ->join('users', 'users.id', '=', 'tickets.id_utilisateur')
            // ->select(
            //     'tickets.*',
            //     'materiels.id as id_materiel',
            //     'materiels.type as type_materiel',
            //     'users.id as id_utilisateur',
            //     'users.prenom_utilisateur as prenom'
            // )
            // ->latest()
            // ->first();
            $dernierTickets = Ticket::with(['utilisateur', 'materiel'])
                ->where('id_utilisateur', $userId)
                ->latest()
                ->first();
$priorite=TicketPrioriteConfig::all();
// dd($priorite);
            // dd($dernierTickets);
            return view('ticketing.utilisateur.app', compact('materiels', 'dernierTickets', 'active_tab','priorite'));
            // return view('dashboard.utilisateur');
        }
    }
}
