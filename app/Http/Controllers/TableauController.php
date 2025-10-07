<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TableauController extends Controller
{
    public function AfficheTableau()
    {
        $utilisateurs = [
            ['id' => 1, 'nom' => 'Alice', 'email' => 'alice@example.com'],
            ['id' => 2, 'nom' => 'Bob', 'email' => 'bob@example.com'],
            ['id' => 3, 'nom' => 'Charlie', 'email' => 'charlie@example.com'],
        ];

        return view('tableau.tableau', compact('utilisateurs'));
    }
}
