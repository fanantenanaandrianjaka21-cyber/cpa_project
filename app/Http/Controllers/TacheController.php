<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function AjoutTache( Request $request){
                $this->validate($request, [
        'id_maintenance'=> 'required',
        'nom_tache'=> 'required',
        'description'=> 'required',
        ]);
                        Tache::create(
                    [
                        
                        'id_maintenance' => $request['id_maintenance'],
                        'nom_tache' => $request['nom_tache'],
                        'description' => $request['description'],

                    ]
                );
                $tache=Tache::where('id_maintenance',$request['id_maintenance'])->get();
        return view('maintenance.maintenance',compact('tache'));
    }
}
