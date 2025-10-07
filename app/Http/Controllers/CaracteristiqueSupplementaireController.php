<?php

namespace App\Http\Controllers;

use App\Models\Materiel;
use App\Models\Emplacement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\CaracteristiqueSupplementaire;
use Spatie\Activitylog\Models\Activity;
class CaracteristiqueSupplementaireController extends Controller
{
    //
    public function voirCaracteristique($id)
    {

        $materiel = Materiel::with('caracteristiques','utilisateurs')->where('id', $id)->get();
        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = MaterielController::recupererLesInfoMateriels($materiel, $colonnes);
        $detail_materiel = $detail_materiel[0];
        // dd($detail_materiel);

        $emplacement = Emplacement::all();
        //  $activities = Activity::latest()->get();
        $activities = Activity::where('subject_type', Materiel::class)
                      ->where('subject_id', $id)
                      ->orderBy('created_at', 'desc')
                      ->get();
        //  dd($activities);
         $active_tab='stock';
        return view('materiel.caracteristique', compact('detail_materiel', 'colonnes', 'i', 'emplacement','activities','active_tab'));
    }
}
