<?php

namespace App\Http\Controllers;

use App\Models\CaracteristiqueSupplementaire;
use App\Models\Materiel;
use App\Models\Inventaire;
use App\Models\Emplacement;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;


class InventaireController extends Controller
{
    public function index()
    {
        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->get();
        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = MaterielController::recupererLesInfoMateriels($materiel, $colonnes);
         $active_tab='inventaire';
        return view('inventaire.inventaire', compact('colonnes', 'i','active_tab'));
    }
    public function generateQr($id)
    {
        $materiel = Materiel::findOrFail($id);
        $qr = QrCode::size(200)->generate($materiel->code_interne);
         $active_tab='inventaire';
        return view('inventaire.qrcode', compact('materiel', 'qr','active_tab'));
    }
    public function scanMateriel($code)
    {
        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        $materiel = Materiel::with('caracteristiques', 'utilisateurs')
            ->where('code_interne', $code)
            ->get();
        if ($materiel->isEmpty()) {
            // matériel non trouvé, mais on renvoie quand même les colonnes
            return response()->json([
                'error' => 'Matériel non trouvé',
                'colonnes' => $colonnes
            ], 404);
        }
        $detail_materiel = MaterielController::recupererLesInfoMateriels($materiel, $colonnes);
        if (isset($detail_materiel[0])) {
            $detail_materiel = $detail_materiel[0];
            $detail_materiel['colonnes'] = $colonnes;
            return response()->json($detail_materiel);
        }
        // Cas improbable : aucune info malgré le matériel existant
        return response()->json([
            'error' => 'Matériel trouvé mais détails manquants',
            'colonnes' => $colonnes
        ], 404);
    }
        public function getColonnes($id)
    {
        $colonnes = DB::table('caracteristique_supplementaires')
            ->select('cle', DB::raw('MIN(id) as first_id'))
            ->where('id_materiel',$id)
            ->groupBy('cle')
            ->orderBy('first_id')
            ->pluck('cle')
            ->toArray();
        return response()->json([
                'colonnes' => $colonnes,
                'id'=>$id
            ], 404);
    }
    // Mettre à jour l'état et observation
    public function updateEtat(Request $request, $id)
    {
        $materiel = Inventaire::findOrFail($id);
        $materiel->etat = $request->etat;
        $materiel->observation = $request->observation;
        $materiel->save();

        return response()->json(['success' => true]);
    }
    public function store(Request $request)
    {
        // Validation de base
        $messages = [
            'id_materiel.required' => 'L’ID matériel est obligatoire.',
            'etat.required' => 'L’état du matériel est obligatoire.',
        ];

        $validated = $request->validate([
            'id_materiel' => 'required|exists:materiels,id',
            'etat' => 'required',
            'composant_manquant' => 'nullable',
            'composant_non_enregistre' => 'nullable',
            'observation' => 'nullable',
            'anciencle' => 'nullable',
            'valeur' => 'nullable',
        ], $messages);

        try {
            $materielId = $validated['id_materiel'];
            $today = now();
            $startOfMonth = $today->copy()->startOfMonth();
            $endOfMonth = $today->copy()->endOfMonth();

            // Vérifier si l'inventaire existe déjà ce mois-ci
            $existing = Inventaire::where('id_materiel', $materielId)
                ->whereBetween('date_inventaire', [$startOfMonth, $endOfMonth])
                ->first();

            if ($existing) {
                return response()->json([
                    'success' => false,
                    'error' => 'Ce matériel a déjà été inventorié.',
                    'anciencle'=>$validated['anciencle'],
                    'valeur'=>$validated['valeur'],
                ], 422);
            }

            // Création de l'inventaire
            $inventaire = Inventaire::create([
                'id_materiel' => $materielId,
                'composant_manquant' => $validated['composant_manquant'] ?? null,
                'composant_non_enregistre' => $validated['composant_non_enregistre'] ?? null,
                'etat' => $validated['etat'],
                'observation' => $validated['observation'] ?? null,
                'date_inventaire' => $today,
            ]);
foreach($validated['anciencle'] as $index=>$col){
    CaracteristiqueSupplementaire::where('id_materiel',$materielId)->where('cle',$col)->update(
    [
'valeur' => $validated['valeur'][$index],
    ]
    );

}
            return response()->json(['success' => true, 'data' => $inventaire]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Inventaire non enregistré',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
