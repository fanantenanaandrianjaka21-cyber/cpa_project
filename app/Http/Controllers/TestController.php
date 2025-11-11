<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function ajouterTicketUtilisateur(Request $data){
        
dd($data);
    }
}
