<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('codes_verifications', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('utilisateur_id');
        $table->string('code');
        $table->timestamp('expire_le');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes_verifications');
    }
};
