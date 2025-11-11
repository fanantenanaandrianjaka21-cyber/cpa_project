<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTicketStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_statuses', function (Blueprint $table) {
            // $table->id();
            $table->string('code')->primary();
            $table->string('label');
            $table->string('color'); 
            $table->timestamps();
        });
            // Insertion des statuts par défaut
    DB::table('ticket_statuses')->insert([
        ['code' => 'NOUVEAU', 'label' => 'Nouveau', 'color' => '#3498db'],
        ['code' => 'ATTRIBUE', 'label' => 'Attribué', 'color' => '#9b59b6'],
        ['code' => 'EN_COURS', 'label' => 'En cours', 'color' => '#f39c12'],
        ['code' => 'PLANIFIE', 'label' => 'Planifié', 'color' => '#2c3e50'],
        ['code' => 'EN_ATTENTE', 'label' => 'En attente', 'color' => '#95a5a6'],
        ['code' => 'RESOLU', 'label' => 'Résolu', 'color' => '#27ae60'],
        ['code' => 'FERME', 'label' => 'Fermé', 'color' => '#2e7d32'],
    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_statuses');
    }
}
