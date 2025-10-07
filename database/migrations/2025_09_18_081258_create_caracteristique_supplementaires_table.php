<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaracteristiqueSupplementairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristique_supplementaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_materiel')
                  ->constrained('materiels')
                  ->onDelete('cascade'); 
            $table->string('cle'); 
            $table->string('valeur');
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
        Schema::dropIfExists('caracteristique_supplementaires');
    }
}
