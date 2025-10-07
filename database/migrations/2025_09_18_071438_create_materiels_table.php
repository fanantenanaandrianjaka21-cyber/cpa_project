<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterielsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiels', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('id_emplacement')
                  ->constrained('emplacements') // nom de la table parente
                  ->onDelete('cascade'); 
            $table->foreignId('id_utilisateur')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('cascade'); 
            $table->string('code_interne')->unique();
            $table->string('type'); 
            $table->string('marque'); 
            $table->string('model'); 
            $table->string('num_serie'); 
            $table->string('status'); 
            $table->string('image'); 
            $table->date('date_aquisition'); 
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
        Schema::dropIfExists('materiels');
    }
}
