<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Codes_verification;
use App\Models\Emplacement;
use App\Models\Materiel;
use App\Models\Ticket;
use App\Models\TicketPrioriteConfig;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


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
        //dd('welcome to dd test');
        $role = Auth::user()->role;
        $userId = Auth::id();
        // dd(Auth::user()->email);
        $email = "fanantenanaandrianjaka21@gmail.com";
        $contact = [
            'nom'    => 'test',
            'email'  => $email,
            'message' => 'Bonjour'
        ];
        // $utilisateur=User::where('id',Auth::user()->id)->get()->first();



        if ($role == "Super Admin") {
            $total_utilisateurs = User::All()->count();
            $total_locales = Emplacement::All()->count();
            $total_materiels = Materiel::All()->sum('quantite');
            $total_tickets = Ticket::count(); // pas besoin de All()->count(), plus performant
            $ticketsOuverts = Ticket::where('statut', 'NOUVEAU')->count();
            $ticketsEncours = Ticket::where('statut', 'EN_COURS')->count();
            $ticketsResolus = Ticket::where('statut', 'FERME')->count();

            $pourcentageFermes = 0;

            if ($total_tickets > 0) {
                $pourcentageFermes = ($ticketsResolus / $total_tickets) * 100;
            }
            $pourcentageFermes = round($pourcentageFermes, 2);

            $materiels_affecte = Materiel::where('status', 'utiliser')->get()->sum('quantite');
            $materiels_disponible = Materiel::where('status', 'disponible')->get()->sum('quantite');
            if ($materiels_affecte != 0) {
                $taux_utilisation_stock = ($materiels_affecte / $total_materiels) * 100;
                $taux_utilisation_stock = round($taux_utilisation_stock, 2);
            } else if ($materiels_disponible != 0 and $materiels_affecte == 0) {
                $taux_utilisation_stock = 0;
            } else {
                $taux_utilisation_stock = '-';
            }
            $alert = Alert::where('id', 1)->get()->first();
            $emplacement = Emplacement::all();
            $utilisateur = User::orderBy('id', 'desc')->first();
            return view('dashboard.super_admin', compact(
                'emplacement',
                'utilisateur',
                'active_tab',
                'alert',
                'total_utilisateurs',
                'total_locales',
                'total_materiels',
                'total_tickets',
                'taux_utilisation_stock',
                'pourcentageFermes'
            ));
        } elseif ($role == "Admin IT") {
            return view('home', compact('active_tab'));
        } elseif ($role == "Responsable Site") {
            return view('home', compact('active_tab'));
        } elseif ($role == "Technicien IT") {
            $userId = Auth::id(); // ID de l'utilisateur connecté
            $materiels = Materiel::all();
            $users = User::all();
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
            $priorite = TicketPrioriteConfig::all();
            // dd($priorite);
            // dd($dernierTickets);
            return view('ticketing.utilisateur.app', compact('materiels', 'dernierTickets', 'active_tab', 'priorite'));
            // return view('dashboard.utilisateur');
        }
    }
}
