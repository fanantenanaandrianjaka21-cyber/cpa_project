<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeMaterielsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_materiels', function (Blueprint $table) {
            $table->id();
                        // Déclare la clé étrangère vers la table 'categories'
            $table->foreignId('id_categorie')
                  ->constrained('categorie_materiels') // nom de la table parente
                  ->onDelete('cascade');     // optionnel : supprimer les types si la catégorie est supprimée
            $table->string('libelle_type');             
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
        Schema::dropIfExists('type_materiels');
    }
}
