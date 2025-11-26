<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportUtilisateurJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function handle()
    {
        $spreadsheet = IOFactory::load($this->path);
        $sheet = $spreadsheet->getSheetByName('utilisateurs_articles');

        $rows = $sheet->toArray(null, true, true, true);
dd($rows);
        $total = count($rows);
        $current = 0;

        Cache::put('progress_import_utilisateur', [
            'progress' => 0,
            'current' => 0,
            'total' => $total
        ]);

        foreach ($rows as $row) {
            $current++;

            // Calcul du pourcentage
            $percent = intval(($current / $total) * 100);

            // ➤ Sauvegarder progression détaillée
            Cache::put('progress_import_utilisateur', [
                'progress' => $percent,
                'current'  => $current,
                'total'    => $total
            ]);

            // === TON TRAITEMENT ICI (inchangé) ===

            if (!array_filter($row)) continue;

            $prenoms = $row['B'] ?? '';
            preg_match('/\d+/', $prenoms, $matches);
            $id = (isset($matches[0])) ? intval($matches[0]) : null;

            if (!$id) continue;

            $prenom = preg_replace('/^(.*) \(\d+ \)$/', '$1', $prenoms);

            $exists = DB::table('users')->where('id', $id)->exists();

            if (!$exists) {
                User::create([
                    'id' => $id,
                    'id_emplacement' => 1,
                    'nom_utilisateur' => $row['A'] ?? null,
                    'prenom_utilisateur' => $prenom,
                    'email' => $row['C'] ?? $id.'@gmail.com',
                    'password' => Hash::make($row['D'] ?? '111111'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Fin = 100 %
        Cache::put('progress_import_utilisateur', [
            'progress' => 100,
            'current'  => $total,
            'total'    => $total
        ]);
    }
}

