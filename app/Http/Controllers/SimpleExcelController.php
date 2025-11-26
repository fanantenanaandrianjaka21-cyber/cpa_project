<?php

namespace App\Http\Controllers;

use App\Jobs\ImportUsersJob;
use App\Models\Affectation;

use App\Models\CaracteristiqueSupplementaire;
use App\Models\Emplacement;
use App\Models\Materiel;
use App\Models\MouvementStock;
use App\Models\User;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class SimpleExcelController extends Controller
{
    // Importer les données
    public function importEtatmateriel(Request $request)
    {
        // 1. Validation du fichier (uniquement .xlsx autorisé)
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx'
        ]);
        // 2. Déplacement du fichier vers le dossier public temporairement
        $fichier = $request->file('fichier');
        $nomFichier = $fichier->hashName();
        $cheminFichier = $fichier->move(public_path(), $nomFichier);

        try {
            // 🧩 Vérifier que le fichier est bien envoyé
            if (!$request->hasFile('fichier')) {
                return back()->with('error', 'Aucun fichier sélectionné.');
            }


            // 🧩 Charger le fichier Excel
            $spreadsheet = IOFactory::load($cheminFichier->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            // 🧩 Convertir toutes les lignes en tableau
            $rows = $sheet->toArray(null, true, true, true);

            // 🧩 Ligne d’en-tête (A8 → ligne 8)
            $headerRow = 8;

            if (!isset($rows[$headerRow])) {
                return back()->with('error', 'Impossible de trouver la ligne d’en-tête (A8).');
            }


            $headers = $rows[$headerRow];

            // 🧩 Nettoyer les en-têtes
            $keys = collect($headers)->map(function ($h) {
                return strtolower(trim(str_replace(
                    [' ', '/', 'é', 'è', 'à', 'ù', 'ô', 'ê', 'î'],
                    ['_', '_', 'e', 'e', 'a', 'u', 'o', 'e', 'i'],
                    $h
                )));
            })->values()->toArray();

            // 🧩 Lire les données après la ligne 8
            $data = [];
            $highestRow = $sheet->getHighestRow();

            for ($row = $headerRow + 1; $row <= $highestRow; $row++) {
                $line = $rows[$row];

                // Ignorer les lignes vides
                if (!array_filter($line)) continue;

                $values = array_values($line);
                $data[] = array_combine($keys, $values);
            }

            // 🧩 Vérifier si on a des données
            if (empty($data)) {
                return back()->with('error', 'Aucune donnée trouvée après la ligne 8.');
            }
            // foreach ($data as $poste) {
            //     // On récupère la localisation depuis le tableau
            //     $localisation = $poste['localisation'] ?? null;

            //     // On saute si la localisation est vide
            //     if (!$localisation) continue;
            //     // Récupérer les 3 premières lettres en majuscules, sans espaces ni caractères spéciaux
            //     $code = Str::upper(Str::substr(Str::slug($localisation, ''), 0, 3));
            //     // On crée un code unique pour la localisation (ex: LOC-001)
            //     // $code = 'LOC-' . Str::padLeft(DB::table('emplacements')->count() + 1, 3, '0');

            //     // Vérifie si cette localisation existe déjà
            //     $exists = DB::table('emplacements')
            //         ->where('emplacement', $localisation)
            //         ->exists();

            //     // Si elle n’existe pas, on insère
            //     if (!$exists) {
            //         DB::table('emplacements')->insert([
            //             'code_emplacement' => $code,
            //             'emplacement' => $localisation,
            //             'created_at' => now(),
            //             'updated_at' => now(),
            //         ]);
            //     }
            // }
            // --- LIRE A1 → A5 ET LEUR VALEUR correspondante dans B1 → B5 ---
            $colorToValue = [];

            for ($i = 1; $i <= 5; $i++) {
                $cellA = 'A' . $i;
                $color = strtoupper($sheet->getStyle($cellA)->getFill()->getStartColor()->getRGB());
                $value = $sheet->getCell('B' . $i)->getValue();

                if ($color !== 'FFFFFF' && $value !== null) {
                    $colorToValue[$color] = $value;
                }
            }

            foreach ($data as $rowIndex => $ligne) {

                $excelRow = $headerRow + 1 + $rowIndex;
                $colonnes = array_keys($ligne);

                foreach ($colonnes as $colIndex => $colKey) {

                    // lettre de la colonne
                    $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                    $cell = $colLetter . $excelRow;

                    // couleur réelle
                    $color = strtoupper($sheet->getStyle($cell)->getFill()->getStartColor()->getRGB());

                    // valeur texte de la cellule Excel
                    $rawText = $sheet->getCell($cell)->getValue();


                    // 🟨🟨🟨 EXCEPTION : COLONNE Q → COMBINER COULEUR + TEXTE 🟨🟨🟨
                    if ($colLetter === 'Q') {

                        $parts = [];

                        // 1️⃣ valeur correspondant à la couleur si existe
                        if (isset($colorToValue[$color])) {
                            $parts[] = $colorToValue[$color];
                        } else {
                            $parts[] = 'aucun';
                        }
                        // 2️⃣ texte réel de la cellule (propre)
                        if (!empty($rawText)) {
                            $cleanText = trim(str_replace(["\n", "\r"], ',', $rawText));
                            $parts[] = $cleanText;
                        } else {
                            $parts[] = 'aucun';
                        }


                        // fusion des 2 valeurs séparées par virgule
                        if (!empty($parts)) {
                            // $data[$rowIndex][$colKey] = implode(',', $parts);
                            $data[$rowIndex][$colKey] = $parts;
                            // dd($data[$rowIndex][$colKey]);
                        }

                        continue; // on passe à la colonne suivante
                    }


                    // 🟩 Pour toutes les autres colonnes → règle normale couleur → valeur
                    if (isset($colorToValue[$color])) {
                        $data[$rowIndex][$colKey] = $colorToValue[$color];
                    }
                }
            }

            $nouveauTableau = [];
            // dd($data);
            foreach ($data as $item) {
                $Emplacement = $item['localisation'] ?? null; // OU autre champ selon ton besoin
                if ($Emplacement == "ANTSIRABE") {
                    $idEmplacement = '2';
                } elseif ($Emplacement == "BNI") {
                    $idEmplacement = '3';
                } elseif ($Emplacement == "MADAFIT") {
                    $idEmplacement = '4';
                } elseif ($Emplacement == "CENTRE") {
                    $idEmplacement = '5';
                } elseif ($Emplacement == "MATURA") {
                    $idEmplacement = '6';
                } else {
                    $idEmplacement = '1';
                }
                $idUtilisateur = $item['id'] ?? null;
                $date_aquisition = $item['date_pc'] ?? now();

                $caracteristique_recu = $item['caracteristique'] ?? $item['caracteristique_'] ?? null;
                // dd($caracteristique_recu);
                $caracteristique = $this->parseCaracteristiques($caracteristique_recu) ?? null;
                $marque_pc = $caracteristique['marque'];
                $processeur = $caracteristique['processeur'];
                $ram = $caracteristique['ram'];
                $disque_dure = $caracteristique['disque_dure'];
                $marque_ecran = $item['ecran'] ?? null;
                // dd($data);
                // dd($data[4]);

                // Première ligne = PC
                if (!$item['code_pc']) continue;
                $nouveauTableau[] = [
                    'id_emplacement' => $idEmplacement,
                    'id_utilisateur' => $idUtilisateur,
                    'code_interne'   => $item['code_pc'],
                    'type'   => 'Ordinateur portable',
                    'quantite'   => '1',
                    'marque'   => $marque_pc,
                    'status'   => 'utiliser',
                    'date_aquisition'   => $date_aquisition,
                ];
                // Vérifie si cette code interne existe déjà
                $exists_materiel = DB::table('materiels')
                    ->where('code_interne', $item['code_pc'])
                    ->exists();
                $exists_utilisateur = DB::table('users')
                    ->where('id', $idUtilisateur)
                    ->exists();
                if (!$exists_utilisateur) continue;
                // Si elle n’existe pas, on insère
                if (!$exists_materiel) {
                    // dd('$data');
                    $objetMateriel = Materiel::create([
                        'id_emplacement' => $idEmplacement,
                        'id_utilisateur' => $idUtilisateur,
                        'code_interne' => $item['code_pc'],
                        'existe_code_interne' => true,
                        'type' => 'Ordinateur portable',
                        'categorie' => 'poste',
                        'quantite' => 1,
                        'marque' => $marque_pc,
                        'status' => 'utiliser',
                        'date_aquisition' => $date_aquisition,

                    ]);
                    // dd('tonga');

                    MouvementStock::create(
                        [
                            'id_materiel' => $objetMateriel->id,
                            'quantite' => '1',
                            'type_mouvement' => 'entree',
                            'emplacement_destination' => $idEmplacement,

                        ]
                    );
                    Affectation::create([
                        'id_materiel' => $objetMateriel->id,
                        'id_emplacement' => $idEmplacement,
                        'id_utilisateur' => $idUtilisateur,
                        'date_affectation' => $date_aquisition,
                    ]);

                    if (!empty($processeur)) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Processeur',
                            'valeur'      => $caracteristique['processeur'],
                        ]);
                    }
                    CaracteristiqueSupplementaire::create([
                        'id_materiel' => $objetMateriel->id,
                        'cle'         => 'Verification_physique',
                        'valeur'      => false,
                    ]);











                    if (!empty($ram)) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Ram',
                            'valeur'      => $caracteristique['ram'],
                        ]);
                    }
                    if (!empty($disque_dure)) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Disque',
                            'valeur'      => $caracteristique['disque_dure'],
                        ]);
                    }
                    if (!empty($item['hdmi'])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Etat HDMI',
                            'valeur'      => $item['hdmi'],
                        ]);
                    }
                    if (!empty($item['clavier'])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Etat Clavier',
                            'valeur'      => $item['clavier'],
                        ]);
                    }
                    if (!empty($item['souris'])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Etat Souris',
                            'valeur'      => $item['souris'],
                        ]);
                    }
                    if (!empty($item['micro_audio'])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Etat Micro',
                            'valeur'      => $item['micro_audio'],
                        ]);
                    }
                    if (!empty($item['etat_du_pc'])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Etat',
                            'valeur'      => $item['etat_du_pc'],
                        ]);
                    }
                    if (!empty($item['mdp_pc'])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Mdp PC',
                            'valeur'      => $item['mdp_pc'],
                        ]);
                    }
                    if (!empty($item['mdp_admin'])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Mdp Admin',
                            'valeur'      => $item['mdp_admin'],
                        ]);
                    }
                    // dd($item['etat_de_la_batterie'][0] ?? $item['etat_de_la_batterie_'][0]);
                    if (!empty($item['etat_de_la_batterie'][0] ?? $item['etat_de_la_batterie_'][0])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Etat Baterie',
                            'valeur'      => $item['etat_de_la_batterie'][0] ?? $item['etat_de_la_batterie_'][0],
                        ]);
                    }
                    if (!empty($item['etat_de_la_batterie'][1] ?? $item['etat_de_la_batterie_'][1])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Duree Baterie',
                            'valeur'      => $item['etat_de_la_batterie'][1] ?? $item['etat_de_la_batterie_'][1],
                        ]);
                    }
                    if (!empty($item['commentaire'])) {
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Commentaire',
                            'valeur'      => $item['commentaire'],
                        ]);
                    }
                }
                // Deuxième ligne = Écran
                $nouveauTableau[] = [
                    'id_emplacement' => $idEmplacement,
                    'id_utilisateur' => $idUtilisateur,
                    'code_interne'   => $item['code_ecran'],
                    'type'   => 'Écran plat',
                    'categorie' => 'poste',
                    'quantite'   => '1',
                    'marque'   => $marque_ecran,
                    'status'   => 'utiliser',
                    'date_aquisition'   => $date_aquisition,

                ];
                if (!empty($item['code_ecran'])) {

                    // Vérifie si cette code interne existe déjà
                    $exists_materiel = DB::table('materiels')
                        ->where('code_interne', $item['code_ecran'])
                        ->exists();

                    // Si elle n’existe pas, on insère
                    if (!$exists_materiel) {
                        // dd('mbola');

                        $objetMateriel = Materiel::create([
                            'id_emplacement' => $idEmplacement,
                            'id_utilisateur' => $idUtilisateur,
                            'code_interne' => $item['code_ecran'],
                            'existe_code_interne' => true,
                            'type' => 'Écran plat',
                            'categorie' => 'Matériel Informatique',
                            'quantite' => 1,
                            'marque' => $marque_ecran,
                            'status' => 'utiliser',
                            'date_aquisition' => $date_aquisition,

                        ]);
                        MouvementStock::create(
                            [
                                'id_materiel' => $objetMateriel->id,
                                'quantite' => '1',
                                'type_mouvement' => 'entree',
                                'emplacement_destination' => $idEmplacement,

                            ]
                        );
                        Affectation::create([
                            'id_materiel' => $objetMateriel->id,
                            'id_emplacement' => $idEmplacement,
                            'id_utilisateur' => $idUtilisateur,
                            'date_affectation' => $date_aquisition,
                        ]);
                        CaracteristiqueSupplementaire::create([
                            'id_materiel' => $objetMateriel->id,
                            'cle'         => 'Verification_physique',
                            'valeur'      => false,
                        ]);
                    }
                }
            }

            // dd($data);

            // dd($nouveauTableau);





            // ✅ Succès
            return back()->with('success', 'Importation réussie avec succès !');
        } catch (\Exception $e) {
            // ⚠️ Gestion des erreurs
            return back()->with('error', 'Erreur lors de l’importation : ' . $e->getMessage());
        }
    }
    function parseCaracteristiques($carac)
    {
        // Séparer par /
        $parts = array_map('trim', explode('/', $carac));

        // Résultat final
        $result = [
            'marque'       => null,
            'processeur'   => null,
            'ram'          => null,
            'disque_dure'  => null,
        ];

        foreach ($parts as $p) {

            // Détection RAM
            if (preg_match('/\b(\d+)\s*(Go|G|GB)\b/i', $p)) {
                $result['ram'] = $p;
                continue;
            }

            // Détection Disque Dur
            if (
                str_contains(strtolower($p), 'ssd') ||
                str_contains(strtolower($p), 'hdd') ||
                preg_match('/\b(\d+)\s*(Go|To|TB)\b/i', $p)
            ) {
                $result['disque_dure'] = $p;
                continue;
            }

            // Détection Processeur (Intel, AMD, etc.)
            if (preg_match('/(i[0-9]|ryzen|intel|amd)/i', $p)) {
                $result['processeur'] = $p;
                continue;
            }

            // Si rien détecté → Marque
            if ($result['marque'] === null) {
                $result['marque'] = $p;
            }
        }

        return $result;
    }

    public function importEmp(Request $request)
    {
        // 1. Validation du fichier (uniquement .xlsx autorisé)
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx'
        ]);

        // 2. Déplacement du fichier vers le dossier public temporairement
        $fichier = $request->file('fichier');
        $nomFichier = $fichier->hashName();
        $cheminFichier = $fichier->move(public_path(), $nomFichier);

        try {
            // 🧩 Vérifier que le fichier est bien envoyé
            if (!$request->hasFile('fichier')) {
                return back()->with('error', 'Aucun fichier sélectionné.');
            }


            // 🧩 Charger le fichier Excel
            $spreadsheet = IOFactory::load($cheminFichier->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            // 🧩 Convertir toutes les lignes en tableau
            $rows = $sheet->toArray(null, true, true, true);

            // 🧩 Ligne d’en-tête (A8 → ligne 8)
            $headerRow = 8;

            if (!isset($rows[$headerRow])) {
                return back()->with('error', 'Impossible de trouver la ligne d’en-tête (A8).');
            }


            $headers = $rows[$headerRow];

            // 🧩 Nettoyer les en-têtes
            $keys = collect($headers)->map(function ($h) {
                return strtolower(trim(str_replace(
                    [' ', '/', 'é', 'è', 'à', 'ù', 'ô', 'ê', 'î'],
                    ['_', '_', 'e', 'e', 'a', 'u', 'o', 'e', 'i'],
                    $h
                )));
            })->values()->toArray();

            // 🧩 Lire les données après la ligne 8
            $data = [];
            $highestRow = $sheet->getHighestRow();

            for ($row = $headerRow + 1; $row <= $highestRow; $row++) {
                $line = $rows[$row];

                // Ignorer les lignes vides
                if (!array_filter($line)) continue;

                $values = array_values($line);
                $data[] = array_combine($keys, $values);
            }

            // 🧩 Vérifier si on a des données
            if (empty($data)) {
                return back()->with('error', 'Aucune donnée trouvée après la ligne 8.');
            }
            // --- LIRE A1 → A5 ET LEUR VALEUR correspondante dans B1 → B5 ---
            $colorToValue = [];

            for ($i = 1; $i <= 5; $i++) {
                $cellA = 'A' . $i;
                $color = strtoupper($sheet->getStyle($cellA)->getFill()->getStartColor()->getRGB());
                $value = $sheet->getCell('B' . $i)->getValue();

                if ($color !== 'FFFFFF' && $value !== null) {
                    $colorToValue[$color] = $value;
                }
            }

            foreach ($data as $rowIndex => $ligne) {

                $excelRow = $headerRow + 1 + $rowIndex;
                $colonnes = array_keys($ligne);

                foreach ($colonnes as $colIndex => $colKey) {

                    // lettre de la colonne
                    $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex + 1);
                    $cell = $colLetter . $excelRow;

                    // couleur réelle
                    $color = strtoupper($sheet->getStyle($cell)->getFill()->getStartColor()->getRGB());

                    // valeur texte de la cellule Excel
                    $rawText = $sheet->getCell($cell)->getValue();


                    // 🟨🟨🟨 EXCEPTION : COLONNE Q → COMBINER COULEUR + TEXTE 🟨🟨🟨
                    if ($colLetter === 'Q') {

                        $parts = [];

                        // 1️⃣ valeur correspondant à la couleur si existe
                        if (isset($colorToValue[$color])) {
                            $parts[] = $colorToValue[$color];
                        }

                        // 2️⃣ texte réel de la cellule (propre)
                        if (!empty($rawText)) {
                            $cleanText = trim(str_replace(["\n", "\r"], ',', $rawText));
                            $parts[] = $cleanText;
                        }

                        // fusion des 2 valeurs séparées par virgule
                        if (!empty($parts)) {
                            $data[$rowIndex][$colKey] = implode(',', $parts);
                        }

                        continue; // on passe à la colonne suivante
                    }


                    // 🟩 Pour toutes les autres colonnes → règle normale couleur → valeur
                    if (isset($colorToValue[$color])) {
                        $data[$rowIndex][$colKey] = $colorToValue[$color];
                    }
                }
            }


            // dd($data);

            foreach ($data as $poste) {
                // On récupère la localisation depuis le tableau
                $localisation = $poste['localisation'] ?? null;

                // On saute si la localisation est vide
                if (!$localisation) continue;
                // Récupérer les 3 premières lettres en majuscules, sans espaces ni caractères spéciaux
                $code = Str::upper(Str::substr(Str::slug($localisation, ''), 0, 3));
                // On crée un code unique pour la localisation (ex: LOC-001)
                // $code = 'LOC-' . Str::padLeft(DB::table('emplacements')->count() + 1, 3, '0');

                // Vérifie si cette localisation existe déjà
                $exists = DB::table('emplacements')
                    ->where('emplacement', $localisation)
                    ->exists();

                // Si elle n’existe pas, on insère
                if (!$exists) {
                    DB::table('emplacements')->insert([
                        'code_emplacement' => $code,
                        'emplacement' => $localisation,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }


            // ✅ Succès
            return back()->with('success', 'Importation réussie avec succès !');
        } catch (\Exception $e) {
            // ⚠️ Gestion des erreurs
            return back()->with('error', 'Erreur lors de l’importation : ' . $e->getMessage());
        }
    }
public function importUtilisateur(Request $request)
{
    $rows = $request->input('data'); 
    $prenoms = [];

    foreach($rows as $user){
        // récupérer la clé contenant "prenom" dynamiquement
        $prenomKey = null;
        foreach(array_keys($user) as $k){
            if(str_contains($k, 'prenom')){
                $prenomKey = $k;
                break;
            }
        }

        $prenom = $prenomKey ? $user[$prenomKey] : '';
        preg_match('/\d+/',$prenom ?? '', $matches);
        $id = isset($matches[0]) ? (int)$matches[0] : null;
        if(!$id) continue;

        $exists = DB::table('users')->where('id',$id)->exists();
        if(!$exists){
            \App\Models\User::create([
                'id' => $id,
                'id_emplacement' => 1,
                'nom_utilisateur' => $user['utilisateur'] ?? null,
                'prenom_utilisateur' => preg_replace('/^(.*) \(\d+\)$/','$1',$prenom),
                'email' => $user['email'] ?? $id.'@gmail.com',
                'password' => Hash::make($user['password'] ?? '111111'),
                'equipe' => $user['equipe'] ?? null,
                'societe' => $user['societe'] ?? null,
                'role' => $user['role'] ?? 'Utilisateur',
                'contact_utilisateur' => $user['contact_utilisateur'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $prenoms[] = preg_replace('/^(.*) \(\d+\)$/','$1',$prenom);
    }

    return response()->json([
        'status' => 'ok',
        'prenoms' => $prenoms
    ]);
}





    // public function importUtilisateur(Request $request)
    // {

    //     // 1. Validation du fichier (uniquement .xlsx autorisé)
    //     $request->validate([
    //         'fichier' => 'required|file|mimes:xlsx'
    //     ]);
    //     // 2. Déplacement du fichier vers le dossier public temporairement
    //     $fichier = $request->file('fichier');
    //     $nomFichier = $fichier->hashName();
    //     $cheminFichier = $fichier->move(public_path(), $nomFichier);

    //     try {
    //         // 🧩 Vérifier que le fichier est bien envoyé
    //         if (!$request->hasFile('fichier')) {
    //             return back()->with('error', 'Aucun fichier sélectionné.');
    //         }


    //         // 🧩 Charger le fichier Excel
    //         $spreadsheet = IOFactory::load($cheminFichier->getRealPath());
    //         $sheet = $spreadsheet->getActiveSheet();
    //         // ⭐️ NOUVEAU : Sélectionner la feuille par son nom 'utilisateurs_articles'
    //         // Ceci remplace $sheet = $spreadsheet->getActiveSheet();
    //         $sheet = $spreadsheet->getSheetByName('utilisateurs_articles');

    //         // ⚠️ Vérification : Si la feuille n'existe pas
    //         if ($sheet === null) {
    //             // Optionnel : Supprimer le fichier temporaire avant de retourner une erreur
    //             unlink($cheminFichier->getRealPath());
    //             return back()->with('error', 'La feuille "utilisateurs_articles" est introuvable dans le fichier.');
    //         }

    //         // 🧩 Convertir toutes les lignes de la feuille sélectionnée en tableau
    //         $rows = $sheet->toArray(null, true, true, true);
    //         // Ne conserver que les colonnes A → D
    //         $rows = array_map(fn($row) => array_slice($row, 0, 4), $rows);
    //         // 🧩 Ligne d’en-tête (A2 → ligne 2)
    //         $headerRow = 2; // Ajustez cette valeur si l'en-tête n'est pas à la ligne 1 de cette feuille.

    //         if (!isset($rows[$headerRow])) {
    //             return back()->with('error', 'Impossible de trouver la ligne d’en-tête (A8).');
    //         }


    //         $headers = $rows[$headerRow];

    //         // 🧩 Nettoyer les en-têtes
    //         $keys = collect($headers)->map(function ($h) {
    //             return strtolower(trim(str_replace(
    //                 [' ', '/', 'é', 'è', 'à', 'ù', 'ô', 'ê', 'î'],
    //                 ['_', '_', 'e', 'e', 'a', 'u', 'o', 'e', 'i'],
    //                 $h
    //             )));
    //         })->values()->toArray();

    //         // 🧩 Lire les données après la ligne 8
    //         $data = [];
    //         $highestRow = $sheet->getHighestRow();
    //         // dd($highestRow);
    //         for ($row = $headerRow + 1; $row <= $highestRow; $row++) {
    //             $line = $rows[$row];

    //             // Ignorer les lignes vides
    //             if (!array_filter($line)) continue;

    //             $values = array_values($line);
    //             $data[] = array_combine($keys, $values);
    //         }

    //         // 🧩 Vérifier si on a des données
    //         if (empty($data)) {
    //             return back()->with('error', 'Aucune donnée trouvée après la ligne 8.');
    //         }

    //         // dd($data);

    //         foreach ($data as $user) {
    //             // On récupère la localisation depuis le tableau
    //             // $matricule = $user['id'] ?? null;
    //             $prenom = preg_replace('/^(.*) \(\d+ \)$/', '$1', $user['prenoms_(id)']);
    //             // preg_match('/\((\d+) \)/', $user['prenoms_(id)'], $matches);
    //             preg_match('/\d+/', $user['prenoms_(id)'], $matches);
    //             // $id = (isset($matches[1])) ? trim($matches[1]) : null;
    //             $id = (isset($matches[0])) ? trim($matches[0]) : null;
    //             $id_entier = (int)$id;
    //             $matricule = $id_entier ?? null;
    //             // dd($matches);
    //             // On saute si la localisation est vide
    //             if (!$matricule) continue;


    //             // Vérifie si cette localisation existe déjà
    //             $exists = DB::table('users')
    //                 ->where('id', $matricule)
    //                 ->exists();

    //             // Si elle n’existe pas, on insère
    //             if (!$exists) {
    //                 User::create([
    //                     'id' => $matricule,
    //                     'id_emplacement' => '1',
    //                     'nom_utilisateur' => $user['utilisateur'],
    //                     'prenom_utilisateur' => $prenom,
    //                     'email' => $user['email'] ?? $matricule . '@gmail.com',
    //                     'password' => Hash::make($user['password'] ?? '111111'),
    //                     'equipe' => $user['equipe'] ?? null,
    //                     'societe' => $user['societe'] ?? null,
    //                     'role' => $user['role'] ?? 'Utilisateur',
    //                     'contact_utilisateur' => $user['contact_utilisateur'] ?? null,
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ]);
    //             }
    //         }

    //         // dd($data);
    //         // ✅ Succès
    //         return back()->with('success', 'Importation réussie avec succès !');
    //     } catch (\Exception $e) {
    //         // ⚠️ Gestion des erreurs
    //         return back()->with('error', 'Erreur lors de l’importation : ' . $e->getMessage());
    //     }
    // }

    // Exporter les données
    public function export(Request $request)
    {

        // 1. Validation des informations du formulaire
        $this->validate($request, [
            'name' => 'bail|required|string',
            'extension' => 'bail|required|string|in:xlsx,csv'
        ]);

        // 2. Le nom du fichier avec l'extension : .xlsx ou .csv
        $file_name = $request->name . "." . $request->extension;

        // 3. On récupère données de la table "utilisateurs"
        $utilisateurs = Utilisateur::select("name", "email", "phone", "address")->get();

        // 4. $writer : Objet Spatie\SimpleExcel\SimpleExcelWriter
        $writer = SimpleExcelWriter::streamDownload($file_name);

        // 5. On insère toutes les lignes au fichier Excel $file_name
        $writer->addRows($utilisateurs->toArray());

        // 6. Lancer le téléchargement du fichier
        $writer->toBrowser();
    }
    public function exportInventaire(Request $request)
    {

        // 1. Validation des informations du formulaire
        $this->validate($request, [
            // 'name' => 'bail|required|string',
            'extension' => 'bail|required|string|in:xlsx,csv'
        ]);
        $date = now()->format('Y-m-d H:i:s');
        $name = 'Inventaire du ' . $date;
        $utilisateurs = User::with([
            'emplacement',
            'materiels.caracteristiqueSupplementaire', // <-- inclure l’état
        ])->get();
        // dd($utilisateurs);
        $resultats = [];
        /** @var \App\Models\User $u */
        // dd($utilisateurs);
        foreach ($utilisateurs as $u) {
            // dd($utilisateurs[1]->materiels);
            // Matériels par type (re-indexés pour accès par indice)
            $pcs    = $u->materiels->where('type', 'Ordinateur portable')->values();
            $ecrans = $u->materiels->where('type', 'Écran plat')->values();
            // $hdmis  = $u->materiels->where('type', 'HDMI')->values();
            // $Clavier  = $u->materiels->where('type', 'Clavier')->values();
            // $Souris  = $u->materiels->where('type', 'Souris')->values();
            // $Micro_audio  = $u->materiels->where('type', 'Microcasque')->values();

            // Nombre max d'éléments (pour parcourir en parallèle)
            $max = max(
                $pcs->count(),
                $ecrans->count(),
                //  $hdmis->count()
            );
            // Si aucun matériel du tout — on ajoute une ligne vide pour l'utilisateur
            if ($max === 0) {
                $resultats[] = [
                    // 'utilisateur' => $u->nom_utilisateur,
                    // 'code_pc'     => null,
                    // 'etat_pc'     => null,
                    // 'code_ecran'  => null,
                    // 'code_hdmi'   => null,
                    // 'localisation'=> $u->emplacement->emplacement ?? null,

                    'Utilisateur' => $u->prenom_utilisateur,
                    'ID' => null,
                    'Equipe' => null,
                    'Date PC' => null,
                    'Caractéristique' => null,
                    'Code PC' => null,
                    'Ecran' => null,
                    'Code Ecran' => null,
                    'HDMI' => null,
                    'Clavier' => null,
                    'Souris' => null,
                    'Micro/Audio' => null,
                    'Etat du PC' => null,
                    'Localisation' => $u->emplacement->emplacement ?? null,
                    'Mdp PC' => null,
                    'Mdp Admin' => null,
                    'Etat de la battérie' => null,
                    'Commentaire' => null,
                ];
                continue;
            }
            // dd($ecrans);

            // Sinon, parcourir en parallèle et construire les lignes
            for ($i = 0; $i < $max; $i++) {
                //                 $marque_pc=$pcs[$i]->marque ??null;
                //                 $processeur=$pcs[$i]?->caracteristiques?->firstWhere('cle', 'Processeur')?->valeur ?? '';
                //                 $ram=$pcs[$i]?->caracteristiques?->firstWhere('cle', 'Ram')?->valeur ?? '';
                //                 $disque=$pcs[$i]?->caracteristiques?->firstWhere('cle', 'Disque')?->valeur ?? '';
                // $caracteristique=$marque_pc.'/'.$processeur.'/'.$ram.'/'.$disque;


                $marque_pc  = $pcs[$i]->marque ?? null;
                // dd($pcs[0]);
                $processeur = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Processeur')?->valeur ?? null;
                $ram        = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Ram')?->valeur ?? null;
                $disque     = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Disque')?->valeur ?? null;
                $hdmis  = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Etat HDMI')?->valeur ?? null;
                $Clavier  = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Etat Clavier')?->valeur ?? null;
                $Souris  = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Etat Souris')?->valeur ?? null;
                $Micro_audio  = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Etat Micro')?->valeur ?? null;
                $caracteristique = collect([$marque_pc, $processeur, $ram, $disque])
                    ->filter(fn($v) => filled($v)) // garde seulement les valeurs non nulles et non vides
                    ->implode('/');
                $etat_batterie = [];
                // 1️⃣ valeur correspondant à la couleur si existe
                if (isset($pcs[$i]?->caracteristiques?->firstWhere('cle', 'Etat Baterie')?->valeur)) {
                    $etat_batterie[] = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Etat Baterie')?->valeur;
                } else {
                    $etat_batterie[] = 'aucun';
                }
                // 2️⃣ texte réel de la cellule (propre)
                if (!empty($pcs[$i]?->caracteristiques?->firstWhere('cle', 'Duree Baterie')?->valeur)) {

                    $etat_batterie[] = $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Duree Baterie')?->valeur;
                } else {
                    $etat_batterie[] = 'aucun';
                }
                // fusion des 2 valeurs séparées par virgule
                if (!empty($etat_batterie)) {
                    $etat_et_duree_batterie = implode(',', $etat_batterie);
                    // dd($data[$rowIndex][$colKey]);
                }
                // dd($etat_batterie);
                $resultats[] = [
                    // 'utilisateur' => $u->nom_utilisateur,
                    // 'code_pc'     => $pcs[$i]->code_interne ?? null,
                    // 'etat_pc'     => $pcs[$i]->caracteristiqueSupplementaire->valeur?? null,
                    // 'code_ecran'  => $ecrans[$i]->code_interne ?? null,
                    // 'code_hdmi'   => $hdmis[$i]->code_interne ?? null,
                    // 'localisation'=> $u->emplacement->nom_localisation ?? null,

                    'Utilisateur' => $u->prenom_utilisateur,
                    'ID' => $u->id,
                    'Equipe' => $u->equipe,
                    'Date PC' => $pcs[$i]->date_aquisition ?? null,
                    'Caractéristique' => $caracteristique,
                    'Code PC' => $pcs[$i]->code_interne ?? null,
                    'Ecran' => $ecrans[$i]->marque ?? null,
                    'Code Ecran' => $ecrans[$i]->code_interne ?? null,
                    'HDMI' => $hdmis,
                    'Clavier' => $Clavier,
                    'Souris' => $Souris,
                    'Micro/Audio' => $Micro_audio,
                    // 'Etat du PC' => $pcs[$i]->caracteristiqueSupplementaire->firstWhere('cle','Etat actuel')?->valeur?? null,
                    'Etat du PC' => $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Etat')?->valeur ?? null,
                    // $pcs[$i]?-> → si $pcs[$i] n’existe pas (par exemple, pas de PC pour cet utilisateur), on évite une erreur.
                    'Localisation' => $u->emplacement->emplacement ?? null,
                    'Mdp PC' => $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Mdp PC')?->valeur ?? null,
                    'Mdp Admin' => $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Mdp Admin')?->valeur ?? null,
                    // 'Etat de la battérie' => $pcs[$i]?->caracteristiques?->firstWhere('cle', 'Etat Baterie')?->valeur ?? null,
                    'Etat de la battérie' => $etat_et_duree_batterie ?? null,

                    'Commentaire' => null,
                ];
            }
        }
        // dd($resultats);

        // 4. $writer : Objet Spatie\SimpleExcel\SimpleExcelWriter
        // $writer = SimpleExcelWriter::streamDownload($file_name);

        // 5. On insère toutes les lignes au fichier Excel $file_name
        // $writer->addRows($detail_materiel->toArray());

        // 6. Lancer le téléchargement du fichier
        // $writer->toBrowser();
        // $path = storage_path("app\public\{$file_name}");
        // 🔹 1. Nom du fichier (pas de caractères interdits)
        $fileBase = 'Inventaire_du_' . now()->format('Y-m-d_His');
        $csvRelativePath = "public/{$fileBase}.csv";
        $xlsxRelativePath = "public/{$fileBase}.xlsx";

        // 🔹 2. Chemins absolus
        $csvPath = storage_path("app/{$csvRelativePath}");
        $xlsxPath = storage_path("app/{$xlsxRelativePath}");

        // 🔹 3. S'assurer que le dossier existe
        Storage::makeDirectory('public');

        // 🔹 4. Exporter les données en CSV avec Spatie
        $writer = SimpleExcelWriter::create($csvPath);
        // $writer->addRows($detail_materiel->toArray());// si type liste on transforme en tableau
        $writer->addRows($resultats); //si type tableau
        $writer->close();

        // 🔹 5. Styliser et convertir en XLSX
        $this->styliserExcel($csvPath, $xlsxPath);
        if ($request->extension == 'csv') {
            return response()->download($csvPath)->deleteFileAfterSend(true);
        }
        // 🔹 6. Télécharger le XLSX final
        return response()->download($xlsxPath)->deleteFileAfterSend(true);
    }
    public function exportMouvement(Request $request)
    {

        // 1. Validation des informations du formulaire
        $this->validate($request, [
            // 'name' => 'bail|required|string',
            'extension' => 'bail|required|string|in:xlsx,csv'
        ]);
        $date = now()->format('Y-m-d H:i:s');
        $name = 'Mouvement de Stock du ' . $date;
        // 2. Le nom du fichier avec l'extension : .xlsx ou .csv
        $file_name = $name . "." . $request->extension;
        $role = Auth::user()->role;
        $id_emplacement = Auth::user()->id_emplacement;
        // 3. On récupère données les caracteristiques du materiel
        if ($role == 'Super Admin' or $role == 'Admin IT') {
            $mouvement = MouvementStock::with('utilisateurs')->get();
        } else {
            $mouvement = MouvementStock::with('utilisateurs')->where('emplacement_destination', $id_emplacement)->get();
        }

        //  dd($mouvement);
        $detail_mouvements = $mouvement->flatMap(function ($mouvement) {

            if ($mouvement->utilisateurs->isEmpty()) {
                if ($mouvement->type_mouvement == 'entree') {
                    $emplacementMateriel = Emplacement::where('id', $mouvement->emplacement_destination)->get()->first();
                    // dd($emplacementMateriel);
                    $destination = $emplacementMateriel->emplacement;
                    $source = $mouvement->source;
                } else {
                    $destination = $mouvement->utilisateur_destination;
                    //  dd($utilisateur_destination);
                    $emplacementMateriel = Emplacement::where('id', $mouvement->source)->get()->first();

                    $source = $emplacementMateriel->emplacement;
                    // dd($source);
                }
                $materiel = Materiel::where('id', $mouvement->id_materiel)->get()->first();
                $model_materiel = $materiel->model;
                $type_materiel = $materiel->type;
                $image_materiel = $materiel->image;
                return [[
                    'matricule' => $mouvement->id,
                    'type_mouvement' => $mouvement->type_mouvement,
                    'quantite' => $mouvement->quantite,
                    'id_materiel' => $mouvement->id_materiel,
                    'model' => $model_materiel,
                    'type' => $type_materiel,
                    'image' => $image_materiel,
                    'source' => $source,
                    'destination' => $destination,
                    'date_mouvement' => $mouvement->created_at,

                    'nom_utilisateur' => '-',
                    'prenom_utilisateur' => '-',
                    'email' => '-',
                ]];
            }

            return $mouvement->utilisateurs->map(function ($user) use ($mouvement) {
                if ($mouvement->type_mouvement == 'entree') {
                    $emplacementMateriel = Emplacement::where('id', $mouvement->emplacement_destination)->get()->first();
                    $destination = $emplacementMateriel->emplacement;
                    $source = $mouvement->source;
                    // dd($destination);
                } else {
                    $destination = $mouvement->utilisateur_destination;
                    //  dd($mouvement);
                    $emplacementMateriel = Emplacement::where('id', $mouvement->source)->get()->first();

                    $source = $emplacementMateriel->emplacement;
                    // dd($source);
                }
                $materiel = Materiel::where('id', $mouvement->id_materiel)->get()->first();

                $model_materiel = $materiel->model;
                $type_materiel = $materiel->type;
                $image_materiel = $materiel->image;
                return [
                    'id' => $mouvement->id,
                    'type_mouvement' => $mouvement->type_mouvement,
                    'quantite' => $mouvement->quantite,
                    'id_materiel' => $mouvement->id_materiel,
                    'model' => $model_materiel,
                    'type' => $type_materiel,
                    'image' => $image_materiel,
                    'source' => $source,
                    'destination' => $destination,
                    'date_mouvement' => $mouvement->created_at,

                    'nom_utilisateur' => $user->nom_utilisateur,
                    'prenom_utilisateur' => $user->prenom_utilisateur,
                    'email' => $user->email,
                ];
            });
        });



        // 4. $writer : Objet Spatie\SimpleExcel\SimpleExcelWriter
        $writer = SimpleExcelWriter::streamDownload($file_name);

        // 5. On insère toutes les lignes au fichier Excel $file_name
        $writer->addRows($detail_mouvements->toArray());

        // 6. Lancer le téléchargement du fichier
        $writer->toBrowser();
    }
    public function recupererLesInfoMateriels($materiel, $colonnes)
    {

        // Utilisateur
        // ID	
        // Equipe
        // Date PC	
        // Caractéristique 
        // Code PC	
        // Ecran	
        // Code Ecran	
        // HDMI	
        // Clavier	
        // Souris	
        // Micro/Audio	
        // Etat du PC	
        // Localisation	
        // Mdp PC	
        // Mdp Admin	
        // Etat de la battérie 	
        // Commentaire

        // Transformer les données en tableau avec clés dynamiques
        $detail_materiel = $materiel->flatMap(function ($materiel) use ($colonnes) {
            $caracts = $materiel->caracteristiques->pluck('valeur', 'cle')->toArray();

            $emplacementMateriel = Emplacement::where('id', $materiel->id_emplacement)->get()->first();
            $base = [
                'ID' => $materiel->id,
                'image' => $materiel->image,
                'id_emplacement' => $materiel->id_emplacement,
                'code_locale' => $emplacementMateriel->code_emplacement,
                'emplacement' => $emplacementMateriel->emplacement,
                // 'code_final' => $emplacementMateriel->code_final,
                'id_utilisateur' => $materiel->id_utilisateur,
                'code_interne' => $materiel->code_interne,
                'date_aquisition' => $materiel->date_aquisition,
                'type' => $materiel->type,
                'quantite' => $materiel->quantite,
                'marque' => $materiel->marque,
                'model' => $materiel->model,
                'num_serie' => $materiel->num_serie,
                'status' => $materiel->status,
            ];

            foreach ($colonnes as $key) {
                $base[$key] = $caracts[$key] ?? '-';
            }
            return [$base];
        });


        // dd($detail_materiel);
        return $detail_materiel; //type liste
    }

    // foction pour styliser le fichier
    private function styliserExcel($csvPath, $xlsxPath)
    {
        $spreadsheet = IOFactory::load($csvPath);
        $sheet = $spreadsheet->getActiveSheet();
        // 🔹 1. Charger les données du CSV
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $data = $sheet->rangeToArray("A1:{$highestColumn}{$highestRow}", null, true, false);

        // 🔹 2. Nettoyer la feuille avant de replacer les données
        $sheet->removeRow(1, $highestRow);

        // 🔹 3. Réécrire les données à partir de A8
        $sheet->fromArray($data, null, 'A8');

        // 🔹 4. Mettre la première ligne (ligne 8) en gras
        $styleHeader = $sheet->getStyle("A8:{$highestColumn}8");
        $styleHeader->getFont()->setBold(true);
        // ✅ Ajuster automatiquement la largeur des colonnes de A à R
        foreach (range('A', 'R') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // 🎨 Couleurs pour A1 à A5
        $colors = ['0070C0', '00B050', 'FFFF00', 'FF0000', '5B87C5']; // rouge, orange, jaune, vert, bleu
        foreach (range(1, 5) as $i) {
            $sheet->getStyle("A{$i}")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB($colors[$i - 1]);
            // $sheet->getRowDimension($i)->setRowHeight(12);
        }
        // $sheet->getRowDimension(6)->setRowHeight(12);


        // ✍️ Valeurs pour B1 à B5
        $values = ['TRES BON', 'BON', 'MOYEN', 'MAUVAIS', 'APPRENTI'];
        foreach ($values as $i => $val) {
            $sheet->setCellValue("B" . ($i + 1), $val);
        }
        // ✅ Fusionner les cellules de A7 à R7
        $sheet->mergeCells('A7:R7');

        // ✅ Écrire le texte
        $sheet->setCellValue('A7', 'ETAT DU MATERIEL INFORMATIQUE');

        // ✅ Appliquer le style (fond gris, texte centré, gras, majuscule)
        $style = $sheet->getStyle('A7:R7');
        $style->getFont()->setBold(true)->setSize(13)->setName('Calibri');
        $style->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('D9D9D9'); // gris clair
        // ✅ Bordure noire autour des cellules
        $style->getBorders()->getAllBorders()
            // ->setBorderStyle(Border::BORDER_THIN)
            ->setBorderStyle(Border::BORDER_MEDIUM)
            ->getColor()->setARGB('FF000000');
        // ✅ Centrer le texte dans toutes les cellules de la ligne 8 (A8 à R8)
        $sheet->getStyle('A8:R8')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // ✅ Centrer toutes les cellules de la colonne B à partir de la ligne 8
        $highestRow = $sheet->getHighestRow(); // récupère la dernière ligne utilisée
        $sheet->getStyle("B8:B{$highestRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        $highestRow = $sheet->getHighestRow(); // récupère la dernière ligne utilisée
        $sheet->getStyle("G8:G{$highestRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $highestRow = $sheet->getHighestRow(); // récupère la dernière ligne utilisée
        $sheet->getStyle("N8:N{$highestRow}")->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);
        // Ajuster la hauteur de la ligne 7
        // $sheet->getRowDimension(7)->setRowHeight(13);

        // colore en vert le cellule qui contient Andrianjaka
        // // Boucle sur les lignes (en supposant que les en-têtes sont sur la première ligne)
        // for ($row = 2; $row <= $highestRow; $row++) {

        //     // Lire la valeur de la colonne A (Utilisateur)
        //     $utilisateur = $sheet->getCell('A' . $row)->getValue();

        //     // Vérifie si c’est “Andrianjaka”
        //     if (trim(strtolower($utilisateur)) === 'andrianjaka') {
        //         // Colorer la ligne entière ou une seule cellule

        //         // 👉 Pour colorer uniquement la cellule de l’utilisateur
        //         $sheet->getStyle('A' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
        //             ->getStartColor()->setARGB('FF00FF00'); // Vert

        //         // 👉 Si tu veux colorer toute la ligne (ex: de A à H)
        //         // $sheet->getStyle('A'.$row.':H'.$row)->getFill()->setFillType(Fill::FILL_SOLID)
        //         //     ->getStartColor()->setARGB('FF00FF00');
        //     }
        // }
        $ligne = 8;

        $sheet->getStyle('A' . $ligne . ':R' . $ligne)->applyFromArray([
            'font' => [
                'bold' => true,
                // 'name' => 'Arial Black', 
                'name' => 'Calibri Black', // police très épaisse
                // 'size' => 11,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'], // Noir
                ],
            ],
        ]);

        // 🔹 Boucle sur toutes les lignes du tableau (à partir de la 8e ligne)
        for ($row = 9; $row <= $highestRow; $row++) {
            // Exemple : tableau de A à R
            $sheet->getStyle('A' . $row . ':R' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '000000'], // Noir
                    ],
                ],
            ]);
            // Lis les valeurs des colonnes concernées
            // ON TESTE INDIQUE LE COLONNE A CHERCHER
            $HDMI = trim($sheet->getCell('I' . $row)->getValue());
            $etatPC = trim($sheet->getCell('M' . $row)->getValue());
            $clavier = trim($sheet->getCell('J' . $row)->getValue());
            $souris = trim($sheet->getCell('K' . $row)->getValue());
            $micro_audio = trim($sheet->getCell('L' . $row)->getValue());
            $etat_batterie = trim($sheet->getCell('Q' . $row)->getValue());
            if ($HDMI === 'TRES BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('0070C0'); // Vert
                $sheet->setCellValue('I' . $row, '');
            } elseif ($HDMI === 'BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00B050'); // Vert
                $sheet->setCellValue('I' . $row, '');
            } elseif ($HDMI === 'MOYEN') {
                $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFF00');
                $sheet->setCellValue('I' . $row, '');
            } elseif ($HDMI === 'MAUVAIS') {
                $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF0000');
                $sheet->setCellValue('I' . $row, '');
            } elseif ($HDMI === 'APPRENTI') {
                $sheet->getStyle('I' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('5B87C5');
                $sheet->setCellValue('I' . $row, '');
            }

            if ($etatPC === 'TRES BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('M' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('0070C0'); // Vert
                $sheet->setCellValue('M' . $row, '');
            } elseif ($etatPC === 'BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('M' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00B050'); // Vert
                $sheet->setCellValue('M' . $row, '');
            } elseif ($etatPC === 'MOYEN') {
                $sheet->getStyle('M' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFF00');
                $sheet->setCellValue('M' . $row, '');
            } elseif ($etatPC === 'MAUVAIS') {
                $sheet->getStyle('M' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF0000');
                $sheet->setCellValue('M' . $row, '');
            } elseif ($etatPC === 'APPRENTI') {
                $sheet->getStyle('M' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('5B87C5');
                $sheet->setCellValue('M' . $row, '');
            }

            if ($clavier === 'TRES BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('J' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('0070C0'); // Vert
                $sheet->setCellValue('J' . $row, '');
            } elseif ($clavier === 'BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('J' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00B050'); // Vert
                $sheet->setCellValue('J' . $row, '');
            } elseif ($clavier === 'MOYEN') {
                $sheet->getStyle('J' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFF00');
                $sheet->setCellValue('J' . $row, '');
            } elseif ($clavier === 'MAUVAIS') {
                $sheet->getStyle('J' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF0000');
                $sheet->setCellValue('J' . $row, '');
            } elseif ($clavier === 'APPRENTI') {
                $sheet->getStyle('J' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('5B87C5');
                $sheet->setCellValue('J' . $row, '');
            }

            if ($souris === 'TRES BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('K' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('0070C0'); // Vert
                $sheet->setCellValue('K' . $row, '');
            } elseif ($souris === 'BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('K' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00B050'); // Vert
                $sheet->setCellValue('K' . $row, '');
            } elseif ($souris === 'MOYEN') {
                $sheet->getStyle('K' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFF00');
                $sheet->setCellValue('K' . $row, '');
            } elseif ($souris === 'MAUVAIS') {
                $sheet->getStyle('K' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF0000');
                $sheet->setCellValue('K' . $row, '');
            } elseif ($souris === 'APPRENTI') {
                $sheet->getStyle('K' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('5B87C5');
                $sheet->setCellValue('K' . $row, '');
            }

            if ($micro_audio === 'TRES BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('L' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('0070C0'); // Vert
                $sheet->setCellValue('L' . $row, '');
            } elseif ($micro_audio === 'BON') {
                // ON TESTE INDIQUE LE COLONNE A COLORER
                $sheet->getStyle('L' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('00B050'); // Vert
                $sheet->setCellValue('L' . $row, '');
            } elseif ($micro_audio === 'MOYEN') {
                $sheet->getStyle('L' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFF00');
                $sheet->setCellValue('L' . $row, '');
            } elseif ($micro_audio === 'MAUVAIS') {
                $sheet->getStyle('L' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF0000');
                $sheet->setCellValue('L' . $row, '');
            } elseif ($micro_audio === 'APPRENTI') {
                $sheet->getStyle('L' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('5B87C5');
                $sheet->setCellValue('L' . $row, '');
            }
            // On découpe par virgule
            if (!empty($etat_batterie)) {
                list($etat_bat, $duree_bat) = explode(',', $etat_batterie);
                // dd($duree_bat);

                if ($etat_bat === 'TRES BON') {
                    // ON TESTE INDIQUE LE COLONNE A COLORER
                    $sheet->getStyle('Q' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('0070C0'); // Vert
                    $sheet->setCellValue('Q' . $row, $duree_bat);
                    // $sheet->getStyle('Q' . $row)->getFont()->getColor()->setARGB('FFFFFF');

                } elseif ($etat_bat === 'BON') {
                    // ON TESTE INDIQUE LE COLONNE A COLORER
                    $sheet->getStyle('Q' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00B050'); // Vert
                    $sheet->setCellValue('Q' . $row, $duree_bat);
                } elseif ($etat_bat === 'MOYEN') {
                    $sheet->getStyle('Q' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FFFF00');
                    $sheet->setCellValue('Q' . $row, $duree_bat);
                } elseif ($etat_bat === 'MAUVAIS') {
                    $sheet->getStyle('Q' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('FF0000');
                    $sheet->setCellValue('Q' . $row, $duree_bat);
                } elseif ($etat_bat === 'APPRENTI') {
                    $sheet->getStyle('Q' . $row)->getFill()->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('5B87C5');
                    $sheet->setCellValue('Q' . $row, $duree_bat);
                } elseif ($etat_bat === 'aucun') {
                    if ($duree_bat != 'aucun') {
                        $sheet->setCellValue('Q' . $row, $duree_bat);
                    } else {
                        $sheet->setCellValue('Q' . $row, '');
                    }
                }
            }

            // Colonne O = Mot de passe
            // $sheet->setCellValue('O'.$row, str_repeat('*', 8)); // remplace par 8 étoiles
        }

        // ///////////
        // 💾 Sauvegarde en .xlsx
        $writer = new Xlsx($spreadsheet);
        $writer->save($xlsxPath);
    }
}
