<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventairesTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_materiel')
                  ->constrained('materiels')
                  ->onDelete('cascade');
            // $table->foreignId('id_emplacement')
            //       ->constrained('emplacements')
            //       ->onDelete('cascade');
            // $table->foreignId('id_utilisateur')
            //       ->nullable()
            //       ->constrained('users')
            //       ->onDelete('cascade');
            // $table->string('etat_materiel');
            // $table->text('observation')->nullable();
        $table->string('composant_manquant')->nullable();
        $table->string('composant_non_enregistre')->nullable();
        $table->string('etat')->nullable();
        $table->text('observation')->nullable();
        $table->date('date_inventaire'); 
                //interdire plusieurs inventaires le même mois :
        $table->unique(['id_materiel', 'date_inventaire']);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventaires');
    }
}
