<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmplacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 public function up()
{
    Schema::create('emplacements', function (Blueprint $table) {
        $table->id();
        $table->string('code_emplacement');
        $table->string('emplacement');
        $table->timestamps();
    });

    DB::table('emplacements')->insert([
        [
            'emplacement' => 'GLOBALE',
            'code_emplacement' => 'GLB',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'ANTSIRABE',
            'code_emplacement' => 'BIRA',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'BNI',
            'code_emplacement' => 'BNI',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'MADAFIT',
            'code_emplacement' => 'MADAFIT',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'CENTRE',
            'code_emplacement' => 'CENTRE',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'MATURA',
            'code_emplacement' => 'MATURA',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ]);
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emplacements');
    }
}
