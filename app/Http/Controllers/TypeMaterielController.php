<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeMateriel;
use App\Models\CategorieMateriel;
use App\Models\Materiel;
use App\Models\Cabinet;
use Illuminate\Support\Facades\DB;

class TypeMaterielController extends Controller
{
    // type materiel
    public function listeType()
    {
        $type = TypeMateriel::all();
        return view('materiel.gestion', compact('type'));
    }
    public function ajoutType(Request $request)
    {
        $this->validate($request, [
            'id_categorie' => 'required',
            'libelle_type' => 'required',
        ]);
        TypeMateriel::create([
            'id_categorie' => $request['id_categorie'],
            'libelle_type' => $request['libelle_type'],
        ]);
        $categorie = CategorieMateriel::all();
        $items_categorie = CategorieMateriel::all();
        // $type=TypeMateriel::all();
        $type = DB::table('categorie_materiels')
            ->join('type_materiels', 'categorie_materiels.id', '=', 'type_materiels.id_categorie')
            ->select('categorie_materiels.*', 'type_materiels.*')
            ->get();
        $items_type = TypeMateriel::all();
        $materiel = Materiel::all();
        $materiel = Materiel::with('caracteristiques')->get();
        // Liste des clés uniques de toutes les caractéristiques
        $colonnes = DB::table('caracteristique_supplementaires')
            ->select('cle', DB::raw('MIN(id) as first_id'))
            ->groupBy('cle')
            ->orderBy('first_id')
            ->pluck('cle')
            ->toArray();
        $i = $colonnes;
        // Transformer les données en tableau avec clés dynamiques

        $detail_materiel = $materiel->map(function ($materiel) use ($colonnes) {
            $base = [
                'id' => $materiel->id,
                'id_cabinet' => $materiel->id_cabinet,
                'id_type' => $materiel->id_type,
                'designation' => $materiel->designation,
                'model' => $materiel->model,
                'serie' => $materiel->serie,
                'status' => $materiel->status,
            ];

            // transformer clé/valeur en colonnes
            $caracts = $materiel->caracteristiques->pluck('valeur', 'cle')->toArray();

            foreach ($colonnes as $key) {
                $base[$key] = $caracts[$key] ?? '-';
            }

            return $base;
        });
        $cabinet = Cabinet::all();
        return view('materiel.gestion', compact('type', 'categorie', 'items_categorie', 'items_type', 'detail_materiel', 'cabinet', 'colonnes', 'i'));
    }
}
