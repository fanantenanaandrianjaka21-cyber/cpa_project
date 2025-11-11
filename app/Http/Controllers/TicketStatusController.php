<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketStatusConfig;
use Illuminate\Http\Request;

class TicketStatusController extends Controller
{
    //
    public function edit()
{
    $statuses = TicketStatusConfig::all();
    return view('ticketing.admin.status_ticket.modifier', compact('statuses'));
}

public function update(Request $request)
{
    foreach ($request->input('colors', []) as $code => $color) {
        TicketStatusConfig::where('code', $code)->update(['color' => $color]);
    }

    return redirect()->back()->with('success', 'Couleurs mises à jour.');
}
public function checkNewTickets(){
    
    $count = Ticket::where('vu',false)->count();
$ticket=Ticket::with(['utilisateur', 'materiel'])->where('vu',false)->orderBy('created_at', 'desc')->get();
    return response()->json([
        'nouveau_tickets' => $count,
        'tickets' => $ticket,
    ]);
}
}
