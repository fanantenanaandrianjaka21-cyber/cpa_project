<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAlertesTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertes_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alerte_id')->constrained('alerts')->onDelete('cascade');
            $table->string('type_materiel');
            $table->integer('niveau_seuil');
            $table->integer('niveau_critique');
            $table->timestamps();
        });
                $type_poste = [
    'Accès Biostar',
    'Décodeur Caméra',
    'Écran plat',
    'Onduleur',
    'Ordinateur portable',
    'Outils de communication',
    'Répéteur Wi-Fi',
    'Routeur',
    'Stabilisateur',
    'Stockage amovible',
    'Switch',
    'Unité centrale',
    'Vidéo projecteur',
    'Frigidaire',
    'Imprimante',
    'Clavier',
    'Souris',
    'Câble alimentation',
    'Adaptateur USB',
    'Adaptateur HDMI',
    'Adaptateur LAN',
    'Microcasque',
    'Clé USB',
    'Câble VGA',
    'Câble HDMI',
    'Câble réseau',
    'Connecteur réseau',
    'Adaptateur prise',
    'Rallonge multiple',
];
foreach ($type_poste as $type) {
    DB::table('alertes_types')->insert([
        'alerte_id'=>1,
        'niveau_seuil' => 5,
        'niveau_critique' => 10,
        'type_materiel' => $type,
    ]);
}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alertes_types');
    }
}
