<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Mail\mailTicket;
use App\Models\Materiel;
use App\enums\TicketStatus;
use App\Mail\nouveauTicket;
use Illuminate\Http\Request;
use App\enums\TicketPriorite;
use App\Models\TicketPrioriteConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
        public function listeTicketAdmin()
    {
        // dd('Ticket Admin');
        if(Auth::user()->role=='Super Admin' OR Auth::user()->role=='Admin IT'){
        Ticket::where('vu', false)->update(['vu' => true]);
        // Ticket::where('vu', true)->update(['vu' => false]);
        }
        $userId = Auth::id(); // ID de l'utilisateur connecté
        $materiels = Materiel::all();
        $users = User::all();
        $Ticket = Ticket::with(['utilisateur', 'materiel','technicien'])->get();
        // dd($Ticket);
        return view('ticketing.admin.liste_ticket', compact('Ticket', 'materiels', 'users'));
    }
    public function detailsTicket($id){
                if(Auth::user()->role=='Super Admin' OR Auth::user()->role=='Admin IT'){
        Ticket::where('vu', false)->where('id',$id)->update(['vu' => true]);

        }
        $ticket = Ticket::with(['utilisateur', 'materiel'])->where('id',$id)->get()->first();
        // dd($ticket);
        $id_demandeur=$ticket->id_utilisateur;
        // $materielUtilisateur=Materiel::where('id_utilisateur',$id_demandeur)->get();
                if (Auth::user()->role == 'Super Admin' or Auth::user()->role == 'Admin IT') {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('id_utilisateur',$id_demandeur)->get();
        } else {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('id_emplacement', Auth::user()->id_emplacement)->where('id_utilisateur',$id_demandeur)->get();
        }

        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $materielUtilisateur = MaterielController::recupererLesInfoMateriels($materiel, $colonnes);
        $roleTechnicien = 'Technicien IT';
        $techniciens = User::where('role', $roleTechnicien)->get();
        $active_tab = 'ticketing';
        return view('ticketing.admin.details_ticket', compact('ticket','active_tab','techniciens','materielUtilisateur'));
    }
        public function detailsTicketTechnicien($id){
        Ticket::where('vu', false)->where('id',$id)->update(['vu' => true]);
        $ticket = Ticket::with(['utilisateur', 'materiel'])->where('id',$id)->get()->first();
        // ajouter aussi l information du materiel
        $active_tab = 'ticketing';
        return view('ticketing.technicien.details_ticket', compact('ticket','active_tab'));
    }
    
    // Affiche uniquement les tickets de l'utilisateur connecté
    public function listeTicketUtilisateur()
    {
        $userId = Auth::id(); // ID de l'utilisateur connecté
        $materiels = Materiel::where('id_utilisateur',$userId)->get();
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
        //         'tickets.created_at',
        //         'users.prenom_utilisateur as utilisateur',
        //         'materiels.type as type',
        //         'tickets.statut',
        //         'tickets.fichier'
        //     )
        //     ->where('tickets.id_utilisateur', $userId)
        //     ->get();
        $tickets = Ticket::with(['utilisateur','materiel','technicien'])
            ->where('id_utilisateur', $userId)
            ->get();
        return view('ticketing.utilisateur.ticket', compact('tickets', 'materiels', 'users'));
    }

    // Permet à l'utilisateur de créer un ticket
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'numero' => 'required',
    //         'nom' => 'required',
    //         'priorite' => 'required',
    //         'id_materiel' => 'required',
    //         'description' => 'required',
    //     ]);

    //     Ticket::create([
    //         'numero' => $request->numero,
    //         'nom' => $request->nom,
    //         'id_utilisateur' => Auth::id(),
    //         'priorite' => $request->priorite,
    //         'id_materiel' => $request->id_materiel,
    //         'description' => $request->description,
    //     ]);

    //     return redirect()->route('mes.tickets')->with('success', 'Ticket créé avec succès.');
    // }

    //Fonction pour une demande de ticket par l'utilisateur connecté
    public function ajouterTicketUtilisateur(Request $data)
    {
        // dd(request('nom_fichier'));
        
        // $ticket = Ticket::find(1);
        // dd($ticket->statut->color());
        // dd($ticket->statut instanceof \App\enums\TicketStatus);
        $users = User::all();
        $materiels = Materiel::all();
        $userId = Auth::id();

        $this->validate(
            $data,
            [
                'type' => 'required',
                'objet' => 'required',
                'priorite' => 'required',
                'description' => 'nullable',
                'assignement' => 'nullable',
            ]
        );
// dd($data['type']);

        $ticket = Ticket::create([
            'type' => $data['type'],
            'objet' => $data['objet'],
            'id_utilisateur' => Auth::id(),
            'priorite' => $data['priorite'],
            'description' => $data['description'],
            'assignement' => $data['assignement'],
            'statut' => TicketStatus::NOUVEAU,
        ]);
        // dd(TicketStatus::NOUVEAU());
        if ($data->hasFile('nom_fichier')) {
            // dd('tonga');
            $fichierPaths = [];

            foreach ($data->file('nom_fichier') as $file) {
                $path = $file->store('fichier', 'public');
                $fichierPaths[] = $path;
            }

            // Enregistre les chemins dans la base (par exemple sous forme de JSON)
            $ticket->update([
                'fichier' => json_encode($fichierPaths),
            ]);
        }
        $demandeur = Auth::user();
        $lienTicket = route('ticketAassigner.ticket', ['id' => $ticket->id]);

        // ✅ Envoi des emails
        if ($demandeur && $demandeur->email) {
            Mail::to($demandeur->email)->send(new mailTicket($ticket, $demandeur));
        }

        Mail::to('onjamalalasahala@gmail.com')->send(new nouveauTicket($ticket, $demandeur));

        // $tickets = Ticket::all();
        //  $dernierTickets = DB::table('tickets')
        //     ->join('materiels', 'materiels.id', '=', 'tickets.id_materiel')
        //     ->join('users', 'users.id', '=', 'tickets.id_utilisateur')
        //     ->select(
        //         'tickets.*',
        //         'materiels.id as id_materiel',
        //         'materiels.type as type_materiel',
        //         'users.id as id_utilisateur',
        //         'users.prenom_utilisateur as prenom'
        //     )
        //     ->latest()
        //     ->first();
        $tickets = Ticket::with(['utilisateur', 'materiel'])
            ->where('id_utilisateur', $userId)
            ->get();
        $dernierTickets = Ticket::with(['utilisateur', 'materiel'])
            ->where('id_utilisateur', $userId)
            ->latest()
            ->first();
            $active_tab = 'dashboard';
$priorite=TicketPrioriteConfig::all();
        return view('ticketing.utilisateur.app', compact('tickets', 'users', 'materiels', 'userId', 'demandeur', 'lienTicket', 'dernierTickets','priorite'));
    }

    //fonction pour l'accueil cad celle qui montrera à l'utilisateur son ticket le plus récent ou ce qu'il vient d'envoyer
    public function accueilTicketUtilisateur()
    {
        $userId = Auth::id(); // ID de l'utilisateur connecté
        $materiels = Materiel::all();
        $users = User::all();

        // $tickets = DB::table('tickets')
        //     ->join('users', 'users.id', '=', 'tickets.id_utilisateur')
        //     ->join('materiels', 'materiels.id', '=', 'tickets.id_materiel')
        //     ->select(
        //         'tickets.id',
        //         'tickets.objetf',
        //         'tickets.priorite',
        //         'tickets.description',
        //         'users.id as user_id',
        //         'users.prenom_utilisateur as utilisateur',
        //         'materiles.id as id_materiel',
        //         'materiels.type as type'
        //     )
        //     ->where('tickets.id_utilisateur', $userId)
        //     ->get();

        //      $dernierTickets = DB::table('tickets')
        //     ->where('id_utilisateur', $userId)
        //     ->latest()
        //     ->limit(1)
        //     ->get();
        $tickets = Ticket::with(['utilisateur', 'materiel'])
            ->where('id_utilisateur', $userId)
            ->get();
        $dernierTicket = Ticket::with(['utilisateur', 'materiel'])
            ->where('id_utilisateur', $userId)
            ->latest()
            ->first();


        return view('utilisateur.app', compact('tickets', 'materiels', 'users', 'dernierTickets'));
    }

    //function pour le dernier ticket que l'utilisateur connecté a envoyer
    public function dernierTicketUtilisateur()
    {
        $tickets = Ticket::all();
        $materiels = Materiel::all();
        $dernierTickets = DB::table('tickets')
            ->join('materiels', 'materiels.id', '=', 'tickets.id_materiel')
            ->select(
                'tickets.*',
                'materiels.id as id_materiel',
                'materiels.type as type'
            )
            ->latest()
            ->first();
        // dd($dernierTickets);
        return view('utilisateur.app', compact('dernierTickets', 'tickets', 'materiels'));
    }

    public function afficherFormulaireAssignation($id)
    {
        $ticket = Ticket::findOrFail($id);

        $materiels = Materiel::all();

     
        $roleTechnicien = 'Technicien IT';
        $techniciens = User::where('role', $roleTechnicien)->get();
        $dernierTickets = DB::table('tickets')
        ->join('users', 'users.id', '=', 'tickets.id_utilisateur')
        ->select(
            'tickets.*',
            'users.id as id_utilisateur',
            'users.prenom_utilisateur as prenom'
        )
        ->latest()
        ->first();
        // $users = User::all(); // pour afficher la liste des utilisateurs à qui on peut assigner

        return view('ticketing.ticketAassigner.ticket', compact('ticket', 'dernierTickets', 'techniciens', 'materiels'));
    }


    public function assignerTicket(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->assignement = $request->assignement;
        $dernierTickets = Ticket::latest()->first();
        // $ticket->statut = 'ouvert'; // change le statut du ticket
        $ticket->statut = TicketStatus::ATTRIBUE; //atao OUVERT
        $ticket->save();
$priorite=TicketPrioriteConfig::all();

        // dd($dernierTickets);

        return redirect()->route('listTicketAdmin')
                         ->with('notification', 'Le ticket a été assigné avec success.');
    }
            public function traiterTicket($id)
    {
        // dd($id);
        $ticket = Ticket::findOrFail($id);
        $dernierTickets = Ticket::latest()->first();
        // $ticket->statut = 'ouvert'; // change le statut du ticket
        $ticket->statut = TicketStatus::EN_COURS; //atao OUVERT
        $ticket->save();
$priorite=TicketPrioriteConfig::all();

        // dd($ticket);

        return redirect()->route('Ticket.details',$id);
    }
        public function terminerTicket(Request $request, $id)
    {
        // dd($id);
        $ticket = Ticket::findOrFail($id);
        $ticket->solution = $request->solution;
        $dernierTickets = Ticket::latest()->first();
        $ticket->statut = TicketStatus::FERME; //atao OUVERT
        $ticket->save();
        // materiel en service
        $priorite=TicketPrioriteConfig::all();

        // dd($ticket);

        return redirect()->route('Ticket.details',$id);
    }


    public function resolution($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('ticketing.technicien.resolution', compact('ticket'));
    }
    // Supprimer un ticket de l'utilisateur
    // public function destroy($id)
    // {
    //     $ticket = Ticket::findOrFail($id);

    //     if ($ticket->id_utilisateur != Auth::id()) {
    //         abort(403, "Vous n'avez pas le droit de supprimer ce ticket.");
    //     }

    //     $ticket->delete();
    //     return redirect()->route('mes.tickets')->with('success', 'Ticket supprimé.');
    // }

    // public function TicketAassigner()
    // {
    //     $tickets = Ticket::all();
    //     return view('ticketAassigner.ticket', compact('tickets'));
    // }
}
