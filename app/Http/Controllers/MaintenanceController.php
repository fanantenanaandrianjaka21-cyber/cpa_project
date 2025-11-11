<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Tache;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function affichePageMaintenance($id_ticket,$id_materiel){
//         $maintenance=Maintenance::create(
//             [
//         'id_ticket'=>$id_ticket,
//         'id_materiel'=>$id_materiel,
//         // 'date_debut'=>'',
//         // 'date_fin'=>,
//             ]
//             );
// $id_maintenance=$maintenance->id;
                // $tache=Tache::where('id_maintenance',$id_maintenance)->get();
        return view('maintenance.maintenance');
    }
}
