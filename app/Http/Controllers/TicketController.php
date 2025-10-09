<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function ajouterTicket(Request $data)
    {
        $this->validate($data ,[
            'numero'=>'required',
            'nom'=>'required',
            'id_utilisateur'=>'required',
            'priorite'=>'required',
            'id_materiel'=>'required',
            'description'=>'required',
        ]);

        $tickets = Ticket::create([
            'numero' => $data['numero'],
            'nom' => $data['nom'],
            'id_utilisateur' => $data['id_utilisateur'],
            'priorite' => $data['priorite'],
            'id_materiel' => $data['id_materiel'],
            'description' => $data['description'],
        ]);

        $tickets = Ticket::all();
        return view('ticket.liste', compact('tickets'));
    }

    public function listeTicket()
    {
        $users = User::all();
        $materiels = Materiel::all();
        $tickets = DB::table('tickets')
        ->join('users', 'users.id','=','tickets.id_utilisateur')
        ->join('materiels', 'materiels.id','=','tickets.id_materiel')
        ->select('tickets.id',
                   'tickets.numero',
                   'tickets.nom',
                   'tickets.priorite',
                   'tickets.description',
                   'users.id as id_utilisateur',
                   'users.nom_utilisateur as utilisateur',
                   'materiels.id as id_materiel',
                   'materiels.type as type'
                )
        ->get();

        //$tickets = Ticket::with('users')->get();

        return view('ticket.liste', compact('tickets', 'users', 'materiels'));
    }

    public function supprimerTicket(Ticket $id)
    {
        $id->delete();

        $tickets = Ticket::all();
        return view('ticket.liste', compact('tickets'));
    }
}
