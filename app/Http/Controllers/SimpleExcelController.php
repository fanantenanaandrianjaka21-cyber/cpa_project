<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;

use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;

class SimpleExcelController extends Controller
{
    // Importer les données
    public function import(Request $request)
    {
        // 1. Validation du fichier (uniquement .xlsx autorisé)
        $request->validate([
            'fichier' => 'required|file|mimes:xlsx'
        ]);

        // 2. Déplacement du fichier vers le dossier public temporairement
        $fichier = $request->file('fichier');
        $nomFichier = $fichier->hashName();
        $cheminFichier = $fichier->move(public_path(), $nomFichier);

        // 3. Lecture du fichier Excel
        try {
            $reader = SimpleExcelReader::create($cheminFichier->getRealPath());
            $rows = $reader->getRows(); // LazyCollection
            $donnees = $rows->toArray();
            $reader->close(); // Toujours fermer le reader

            // 4. Insertion dans la base de données
            $status = Utilisateur::insert($donnees);

            // 5. Suppression du fichier temporaire
            if (file_exists($cheminFichier)) {
                unlink($cheminFichier);
            }

            // 6. Retour avec message
            if ($status) {
                return back()->with('msg', 'Importation réussie !');
            } else {
                return back()->withErrors(['import' => 'Échec de l’insertion en base de données.']);
            }
        } catch (\Exception $e) {
            // Nettoyage en cas d'erreur
            if (isset($reader)) {
                $reader->close();
            }

            if (isset($cheminFichier) && file_exists($cheminFichier)) {
                @unlink($cheminFichier); // Suppression silencieuse
            }

            return back()->withErrors(['import' => 'Erreur lors de l’importation : ' . $e->getMessage()]);
        }
    }

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
}
