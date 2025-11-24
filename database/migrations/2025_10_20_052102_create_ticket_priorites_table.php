<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTicketPrioritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_priorites', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('label');
            $table->string('color'); 
            $table->timestamps();
        });
            // Insertion des statuts par défaut
        DB::table('ticket_priorites')->insert([
            ['code' => 'TRES_BASSE', 'label' => 'Très basse', 'color' => '#007bff'],
            ['code' => 'BASSE', 'label' => 'Basse', 'color' => '#fd7e14'],
            ['code' => 'MOYENNE', 'label' => 'Moyenne', 'color' => '#28a745'],
            ['code' => 'URGENT', 'label' => 'Urgent', 'color' => '#f92811ff'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_priorites');
    }
}
