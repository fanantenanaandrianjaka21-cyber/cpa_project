<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_materiel')
                  ->constrained('materiels')
                  ->onDelete('cascade');
            $table->foreignId('id_emplacement')
                  ->constrained('emplacements')
                  ->onDelete('cascade');
            $table->foreignId('id_utilisateur')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->date('date_affectation');
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
        Schema::dropIfExists('affectations');
    }
}
