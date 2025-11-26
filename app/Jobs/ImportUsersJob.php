<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Events\UserImportProgress;

class ImportUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle()
    {
        $spreadsheet = IOFactory::load($this->filePath);
        $sheet = $spreadsheet->getSheetByName('utilisateurs_articles');
        if(!$sheet) return;

        $rows = $sheet->toArray(null, true, true, true);
        $rows = array_map(fn($row) => array_slice($row,0,4), $rows);
        $headerRow = 2;
        $headers = $rows[$headerRow];
        $keys = collect($headers)->map(function($h){
            return strtolower(trim(str_replace(
                [' ', '/', 'é','è','à','ù','ô','ê','î'],
                ['_','_','e','e','a','u','o','e','i'],
                $h
            )));
        })->values()->toArray();

        $data = [];
        $highestRow = $sheet->getHighestRow();
        for($row=$headerRow+1; $row<=$highestRow; $row++){
            $line = $rows[$row];
            if(!array_filter($line)) continue;
            $values = array_values($line);
            $data[] = array_combine($keys,$values);
        }

        $total = count($data);
        foreach($data as $index => $user){
            $prenom = preg_replace('/^(.*) \(\d+\)$/','$1',$user['prenoms_(id)']);
            preg_match('/\d+/',$user['prenoms_(id)'],$matches);
            $matricule = isset($matches[0]) ? (int)$matches[0] : null;
            if(!$matricule) continue;

            $exists = DB::table('users')->where('id',$matricule)->exists();
            if(!$exists){
                $newUser = User::create([
                    'id'=>$matricule,
                    'id_emplacement'=>1,
                    'nom_utilisateur'=>$user['utilisateur'],
                    'prenom_utilisateur'=>$prenom,
                    'email'=>$user['email'] ?? $matricule.'@gmail.com',
                    'password'=>Hash::make($user['password'] ?? '111111'),
                    'equipe'=>$user['equipe'] ?? null,
                    'societe'=>$user['societe'] ?? null,
                    'role'=>$user['role'] ?? 'Utilisateur',
                    'contact_utilisateur'=>$user['contact_utilisateur'] ?? null,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]);
            } else {
                $newUser = null;
            }

            // 🔥 broadcast progression
            event(new UserImportProgress($index+1, $total, $newUser));
            usleep(50000); // 50ms pour simuler progression visible
        }
    }
}
