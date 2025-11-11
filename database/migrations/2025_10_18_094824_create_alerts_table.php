<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            // $table->string('email_destinataire');
            // $table->string('niveau_seuil');
            // $table->string('niveau_critique');
            // $table->string('type_materiel');
            $table->boolean('par_jour')->default(true);
            $table->time('heure_envoie_par_jour');
            $table->boolean('hebdomadaire')->default(true);
            $table->string('jour_du_semaine');
            $table->time('heure_envoie_par_semaine');
            $table->timestamp('derniere_envoi')->nullable();
            $table->timestamps();
        });
//         $type_poste = [
//     'Accès Biostar',
//     'Décodeur Caméra',
//     'Écran plat',
//     'Onduleur',
//     'Ordinateur portable',
//     'Outils de communication',
//     'Répéteur Wi-Fi',
//     'Routeur',
//     'Stabilisateur',
//     'Stockage amovible',
//     'Switch',
//     'Unité centrale',
//     'Vidéo projecteur',
//     'Frigidaire',
//     'Imprimante',
//     'Clavier',
//     'Souris',
//     'Câble alimentation',
//     'Adaptateur USB',
//     'Adaptateur HDMI',
//     'Adaptateur LAN',
//     'Microcasque',
//     'Clé USB',
//     'Câble VGA',
//     'Câble HDMI',
//     'Câble réseau',
//     'Connecteur réseau',
//     'Adaptateur prise',
//     'Rallonge multiple',
// ];
// foreach ($type_poste as $type) {
//     DB::table('alerts')->insert([
//         'email_destinataire' => 'fanantenanaandrianjaka21@gmail.com',
//         'niveau_seuil' => 5,
//         'niveau_critique' => 10,
//         'type_materiel' => $type,
//         'par_jour' => true,
//         'heure_envoie_par_jour' => '18:00',
//         'hebdomadaire' => true,
//         'jour_du_semaine' => 'Lundi',
//         'heure_envoie_par_semaine' => '08:00',
//     ]);
// }

    DB::table('alerts')->insert([
        'par_jour' => true,
        'heure_envoie_par_jour' => '18:00',
        'hebdomadaire' => true,
        'jour_du_semaine' => 'Lundi',
        'heure_envoie_par_semaine' => '08:00',
    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alerts');
    }
}
