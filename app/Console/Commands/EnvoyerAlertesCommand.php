<?php

namespace App\Console\Commands;

use App\Http\Controllers\MaterielController;
use App\Mail\AlerteStockMail;
use App\Models\Alert;
use App\Models\Alertes_destinataires;
use App\Models\Alertes_types;
use App\Models\Emplacement;
use App\Models\Materiel;
use App\Models\MouvementStock;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnvoyerAlertesCommand extends Command
{
    protected $signature = 'alertes:envoyer';
    protected $description = 'Envoie automatique des emails d’alerte selon la configuration en base';

    public function handle()
    {
        $maintenant = \Carbon\Carbon::now();
        $jour = $maintenant->locale('fr_FR')->dayName;
        // $heure = $maintenant->format('H:i') . ':00';
        $heure = $maintenant->format('H:i:s');

        // $alerte = DB::table('alerts')->get()->first();
        $alerte=Alert::all()->first();
        $destinataires = Alertes_destinataires::All();

        $anyMailSent = false;

        // foreach ($alertes as $alerte) {
        // Envoi quotidien
        // $this->envoyerMail($alerte);
        $heureAlerte = \Carbon\Carbon::createFromFormat('H:i:s', $alerte->heure_envoie_par_jour);
        $diffEnMinutes = abs($maintenant->diffInMinutes($heureAlerte, false));
        // éviter les doublons le même jour
        $derniereEnvoi = $alerte->derniere_envoi ? \Carbon\Carbon::parse($alerte->derniere_envoi) : null;
        $dejaEnvoye = $derniereEnvoi && $derniereEnvoi->isSameDay($maintenant);
        Log::info('⏰ Planificateur exécuté par Njaka à : ' . now() . 'h ' . $alerte->id);

        // Envoi quotidien
        if ($alerte->par_jour && $diffEnMinutes <= 5 && !$dejaEnvoye)
        // if ($alerte->par_jour && $heure == $alerte->heure_envoie_par_jour)
        {
            // Log::info('⏰ Planificateur exécuté par Njaka à : ' . now());
            foreach ($destinataires as $email) {
                $this->envoyerMail($alerte, $email->email_destinataire);
            }
            // $this->envoye();
            // DB::table('alerts')->where('id', $alerte->id)->update(['derniere_envoi' => now()]);
            $alerte->derniere_envoi = now();
            $alerte->save();
            $anyMailSent = true;
        }
        //    $this->envoye();

        // $anyMailSent = true;
        // Envoi hebdomadaire
        // Log::info('⏰ Jour  : '.ucfirst($jour));
        // Log::info('⏰ Jour  : '.ucfirst($alerte->jour_du_semaine));

        if ($alerte->hebdomadaire && ucfirst($jour) == $alerte->jour_du_semaine && $heure == $alerte->heure_envoie_par_semaine) {
            $this->envoyerMail($alerte, $email);
            $anyMailSent = true;
            //   Log::info('⏰ Alerte par semmaine envoye avec success ');
        }
        if (!$anyMailSent) {
            $this->info("Aucun mail n'a été envoyé à cette heure." . $heure . ' vs ' . $alerte->heure_envoie_par_jour);
        } else {
            $this->info("Tous les mails prévus ont été envoyés.");
        }
    }
    // }

    protected function envoyerMail($alerte, $email)
    {

        $materiel = Materiel::with('caracteristiques', 'utilisateurs')->where('status', 'disponible')->get();
        $colonnes = MaterielController::recupererColonnes('caracteristique_supplementaires', 'cle');
        $detail_materiel = MaterielController::recupererLesInfoMateriels($materiel, $colonnes);

        $materielpartype = collect($detail_materiel)
            ->groupBy('type')
            ->map(function ($materiel) {
                $materielemplacement = collect($materiel)
                    ->where('type', $materiel[0]['type'])->where('emplacement', '!=', 'GLOBALE')
                    ->groupBy('emplacement')
                    ->map(function ($emplacement) {
                        return [
                            'id_emplacement' => $emplacement[0]['id_emplacement'],
                            'nom_emplacement' => $emplacement[0]['emplacement'],
                            'quantite' => $emplacement->sum('quantite'),
                            'emplacement' => $emplacement,
                        ];
                    })
                    ->values();
                // IL FAUT METTRE GLOBALE
                $non_distribue = $materiel->where('emplacement', 'GLOBALE')->sum('quantite');
                $Total_en_stock = $materiel->where('emplacement', '!=', 'GLOBALE')->sum('quantite');
                // dd($non_distribue);
                return [
                    'materielemplacement' => $materielemplacement,
                    'type' => $materiel[0]['type'],
                    'non_distribue' => $non_distribue,
                    'quantite' => $Total_en_stock,
                    'materiel' => $materiel,
                ];
            })
            ->values();
        // dd($materielpartype);

        // $alert = Alert::All();
        $alert=Alertes_types::All();
        $mouvement = MouvementStock::with('utilisateurs')->get();


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
        try {

            // Mail::to($alerte->email_destinataire)->send(
            //     new \App\Mail\AlerteStockMail($alerte->type_materiel, $alerte->niveau_seuil, $alerte->niveau_critique)
            // );

            Mail::to($email)->send(new \App\Mail\AlerteStockMail($materielpartype, $alert, $detail_mouvements));
            Log::info('after send');

            // Log dans le terminal
            $this->info("✅ Mail envoyé à : {$alerte->email_destinataire} pour le matériel : {$alerte->type_materiel}");

            // Stocker dans mail_logs
            DB::table('mail_logs')->insert([
                'email_destinataire' => $alerte->email_destinataire,
                'type_materiel' => $alerte->type_materiel,
                'niveau_seuil' => $alerte->niveau_seuil,
                'niveau_critique' => $alerte->niveau_critique,
                'envoye_le' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } catch (\Exception $e) {
            Log::error('catch' . $e->getMessage());

            $this->error("❌ Erreur en envoyant à {$alerte->email_destinataire}: " . $e->getMessage());
        }
    }
}
