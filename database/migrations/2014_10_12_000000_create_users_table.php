<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('id')->primary();
            $table->foreignId('id_emplacement')
                ->constrained('emplacements') // nom de la table parente
                ->onDelete('cascade');
            $table->string('name')->nullable();

            $table->string('nom_utilisateur');
            $table->string('prenom_utilisateur');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('equipe')->nullable();
            $table->string('societe')->nullable();
            $table->enum('role',['Utilisateur','Technicien IT','Responsable Site','Admin IT','Super Admin'])
                ->default('Utilisateur');
            $table->string('contact_utilisateur')->nullable();
            $table->string('pin')->nullable();
            $table->string('image')->nullable(); 
            $table->rememberToken();
            $table->timestamps();
        });
            DB::table('users')->insert(
            [
                [
                'id' => 34025,
                'id_emplacement' =>2,
                'nom_utilisateur' => 'Andrianjaka',
                'prenom_utilisateur' => 'Fanantenana',
                // 'email' => 'sahala@gmail.com',
                'password' => Hash::make('qwertyuiop'),
                'equipe' => 'Administration',
                'societe' => 'Experts CPA',
                'role' => 'Super Admin',
                'contact_utilisateur' => '0334456987',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'id' => 442,
                'id_emplacement' =>2,
                'nom_utilisateur' => 'RATEFIARISON Maherisoa Olivah',
                'prenom_utilisateur' => 'Maherisoa',
                // 'email' => 'mihossiraman@gmail.com',
                'password' => Hash::make('adminmdp'),
                'equipe' => 'Info',
                'societe' => 'CPA',
                'role' => 'Super Admin',
                'contact_utilisateur' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'id' => 900,
                'id_emplacement' =>2,
                'nom_utilisateur' => 'RANDRIAMIARINIRINA Tahina Maminiaina ',
                'prenom_utilisateur' => 'Maminiaina',
                // 'email' => 'Maherisoa@gmail.com',
                'password' => Hash::make('utilisateurmdp'),
                'equipe' => 'Apprenti',
                'societe' => 'CPA',
                'role' => 'Utilisateur',
                'contact_utilisateur' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ],
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}