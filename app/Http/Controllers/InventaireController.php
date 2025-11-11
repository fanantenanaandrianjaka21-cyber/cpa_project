<?php

namespace App\Http\Controllers;

use App\Models\CaracteristiqueSupplementaire;
use App\Models\Emplacement;
use App\Models\Inventaire;
use App\Models\Materiel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class InventaireController extends Controller
{
    public function index()
    {
        if (Auth::User()->role == 'Super Admin' or Auth::User()->role == 'Admin IT') {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'utiliser')->get();
        } else {
            $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'utiliser')->where('id_emplacement', Auth::User()->id_emplacement)->get();
        }

        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        $i = $colonnes;
        $detail_materiel = MaterielController::recupererLesInfoMateriels($materiel, $colonnes);
        $detail_materiel1 = $detail_materiel;
        $emplacement = Emplacement::all();
        // dd($detail_materiel);
        // verification physique
        //                     $today = now();
        //             $startOfMonth = $today->copy()->startOfMonth();
        //             $endOfMonth = $today->copy()->endOfMonth();
        // foreach($detail_materiel as $index=>$materiel){
        //  $existing = Inventaire::where('id_materiel', $materiel['id'])
        //                 ->whereBetween('date_inventaire', [$startOfMonth, $endOfMonth])
        //                 ->first();
        // // dd($index);
        // dd($detail_materiel[$index]);
        //  $detail_materiel[$index]['verification_physique']=false;
        //  $detail_materiel[$index]['observation']='';
        // if($existing){
        // $detail_materiel[$index]['verification_physique']=true;
        //  $detail_materiel[$index]['observation']=$existing->observation;
        // }
        // }
            // dd($detail_materiel);

        // Vérifier si l'inventaire existe déjà ce mois-ci

        $active_tab = 'inventaire';
        return view('inventaire.inventaire', compact('colonnes', 'i', 'active_tab', 'detail_materiel', 'detail_materiel1'));
    }
    public function generateQr($id)
    {
        $materiel = Materiel::findOrFail($id);
        $qr = QrCode::size(200)->generate($materiel->code_interne);
        $active_tab = 'inventaire';
        return view('inventaire.qrcode', compact('materiel', 'qr', 'active_tab'));
    }
    public function scanMateriel($code)
    {
        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        // $materiel = Materiel::with('caracteristiques', 'utilisateurs')
        //     ->where('code_interne', $code)
        //     ->get();
        $materiel = Materiel::with(['caracteristiques', 'utilisateurs'])
            ->whereHas('utilisateurs', function ($query) use ($code) {
                $query->where('nom_utilisateur', $code);
            })
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
            ->where('id_materiel', $id)
            ->groupBy('cle')
            ->orderBy('first_id')
            ->pluck('cle')
            ->toArray();
        return response()->json([
            'colonnes' => $colonnes,
            'id' => $id
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
                    'anciencle' => $validated['anciencle'],
                    'valeur' => $validated['valeur'],
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
            foreach ($validated['anciencle'] as $index => $col) {
                CaracteristiqueSupplementaire::where('id_materiel', $materielId)->where('cle', $col)->update(
                    [
                        'valeur' => $validated['valeur'][$index],
                    ]
                );
            }
                                        CaracteristiqueSupplementaire::where('id_materiel', $materielId)->where('cle', 'Verification_physique')->update(
                    [
                        'valeur' => 'true',
                    ]
                );
            return response()->json(['success' => true, 'data' => $inventaire]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Inventaire non enregistré',
                'message' => $e->getMessage()
            ], 500);
        }
    }
      public function modifier(Request $request)
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
            foreach ($validated['anciencle'] as $index => $col) {
                CaracteristiqueSupplementaire::where('id_materiel', $materielId)->where('cle', $col)->update(
                    [
                        'valeur' => $validated['valeur'][$index],
                    ]
                );
            }
                            CaracteristiqueSupplementaire::where('id_materiel', $materielId)->where('cle', 'Verification_physique')->update(
                    [
                        'valeur' => 'false',
                    ]
                );
            return response()->json(['success' => true,
            //  'data' => $inventaire
            ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Mise à jour non enregistré',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
