<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAlertesDestinatairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alertes_destinataires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alerte_id')->constrained('alerts')->onDelete('cascade');
            $table->string('email_destinataire');
            $table->timestamps();
        });
        DB::table('alertes_destinataires')->insert([
            'alerte_id' => 1,
            'email_destinataire' => 'fanantenanaandrianjaka21@gmail.com',

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alertes_destinataires');
    }
}
