<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_utilisateur')
                ->constrained('users')
                ->onDelete('cascade');
            $table->enum('type', ['Incident', 'Demande']);
            $table->string('objet')->nullable();
            $table->string('priorite')->nullable();
            $table->text('description')->nullable();
            $table->text('solution')->nullable();
            $table->string('assignement')->nullable();
            $table->string('statut')->nullable();
            $table->string('fichier')->nullable();
            $table->boolean('vu')->default(false);
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
        Schema::dropIfExists('tickets');
    }
}
