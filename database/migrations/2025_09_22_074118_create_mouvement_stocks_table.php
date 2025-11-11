<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMouvementStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mouvement_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_materiel')
                ->constrained('materiels')
                ->onDelete('cascade');
            $table->string('quantite')
                ->nullable();
            $table->string('source')
                ->nullable();
            $table->string('emplacement_destination')
                ->nullable();
            $table->string('utilisateur_destination')
                ->nullable();
            $table->string('type_mouvement');
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
        Schema::dropIfExists('mouvement_stocks');
    }
}
