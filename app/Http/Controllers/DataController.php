<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Materiel;
use App\Models\Affectation;
use App\Models\Emplacement;
use Illuminate\Http\Request;
use App\Models\MouvementStock;
use Illuminate\Support\Facades\Hash;
use App\Models\CaracteristiqueSupplementaire;

class DataController extends Controller
{
   public function ajouterEmplacements()
{
// Antsirabe
// BNI
// Madafit
// Centre
// Matura 
    $emplacements = [
        [
            'emplacement' => 'Antsirabe',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'BNI',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'Madafit',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'Centre',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'emplacement' => 'Matura',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    // insertion en bulk
    Emplacement::insert($emplacements);

    $notification = 'Tous les emplacements ont été ajoutés avec succès';
    $emplacement = Emplacement::all();

    return $notification;
}
public function ajouterUtilisateurs()
{
    $utilisateurs = [
                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'Andrianjaka',
            'prenom_utilisateur' => 'Fanantenana',
            'email' => 'fana@gmail.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Administration',
            'societe' => 'Experts CPA',
            'role' => 'Super Admin',
            'contact_utilisateur' => '0321234567',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_emplacement' => 2,
            'nom_utilisateur' => 'Randria',
            'prenom_utilisateur' => 'Jean',
            'email' => 'randria@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Equipe A',
            'societe' => 'Societe X',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0321234567',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_emplacement' => 4,
            'nom_utilisateur' => 'RALAMBOMANDIMBY Andomalala Antoine',
            'prenom_utilisateur' => 'Ando',
            'email' => 'ando@example.com',
            'password' => Hash::make('password456'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0339876543',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RANDRIAMPARANY Kerena',
            'prenom_utilisateur' => 'Antsa',
            'email' => 'antsa@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Administration',
            'societe' => 'CPA',
            'role' => 'Responsable Site',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'JOYICE Brondonne',
            'prenom_utilisateur' => 'Brondonne',
            'email' => 'brondonne@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RAKOTONOMENJANAHARY Davidson',
            'prenom_utilisateur' => 'Erica',
            'email' => 'erica@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Comptastar',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RAFANOMEZANTSOA Fanantenana E. D.',
            'prenom_utilisateur' => 'Fanantenana',
            'email' => 'fanantenana@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'MyU',
            'societe' => 'RFC',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                        [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RASOAFANIRY Viviane M. C.',
            'prenom_utilisateur' => 'Fanie',
            'email' => 'fanie@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                        [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'SOLOFOARIMANANA',
            'prenom_utilisateur' => 'Fanirisoa',
            'email' => 'fanirisoa@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                        [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RAMBELONOROMANANA  Faniriniaina Michel',
            'prenom_utilisateur' => 'Faniry',
            'email' => 'faniry@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                        [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RAKOTOSALAMA Manitra',
            'prenom_utilisateur' => 'Hariniaina',
            'email' => 'hariniaina@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RATSIMBA Lovanirina',
            'prenom_utilisateur' => 'Harivony',
            'email' => 'harivony@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'ANDRIANANTOANDRO F.',
            'prenom_utilisateur' => 'Henintsoa',
            'email' => 'henintsoa@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RAKOTONDRAINIBE Onintsoa Ianjanirina',
            'prenom_utilisateur' => 'Ianja',
            'email' => 'ianja@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'MANDIMBISOA N. E.',
            'prenom_utilisateur' => 'Jeannie',
            'email' => 'jeannie@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Audit',
            'societe' => 'CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'Véronique',
            'prenom_utilisateur' => 'Mamisoa',
            'email' => 'mamisoa@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Myu',
            'societe' => 'RFC',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                        [
            'id_emplacement' => 1,
            'nom_utilisateur' => 'RATEFIARISON Olivah',
            'prenom_utilisateur' => 'Maherisoa',
            'email' => 'maherisoa@example.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Informatique',
            'societe' => 'CPA',
            'role' => 'Admin IT',
            'contact_utilisateur' => '0341239876',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    User::insert($utilisateurs);

    $notification = "Tous les utilisateurs ont été ajoutés avec succès";


    return $notification;
}
public function ajouterMateriels()
{
    $materiels = [
        [
            'id_emplacement' => 1,
            'type' => 'PC Portable',
            'marque' => 'HP',
            'model' => 'EliteBook 840',
            'num_serie' => 'HP-123456',
            'status' => 'utilisé',
            'image' => 'imageMateriel/pc1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_emplacement' => 2,
            'type' => 'Imprimante',
            'marque' => 'Canon',
            'model' => 'i-SENSYS LBP6030',
            'num_serie' => 'CN-654321',
            'status' => 'stocké',
            'image' => 'imageMateriel/printer1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_emplacement' => 1,
            'type' => 'Switch Réseau',
            'marque' => 'Cisco',
            'model' => 'SG350-10',
            'num_serie' => 'CISCO-987654',
            'status' => 'utilisé',
            'image' => 'imageMateriel/switch1.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    // ✅ Insertion en bulk
    Materiel::insert($materiels);

    $notification = "Tous les matériels ont été ajoutés avec succès";

    return $notification ;
}
public function ajouterCaracteristiques()
{
    $caracteristiques = [
        [
            'id_materiel' => 1,  // id du matériel existant
            'cle' => 'Processeur',
            'valeur' => 'Intel Core i7',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_materiel' => 1,
            'cle' => 'Mémoire RAM',
            'valeur' => '16 Go DDR4',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_materiel' => 1,
            'cle' => 'Disque',
            'valeur' => 'SSD 512 Go',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_materiel' => 2,
            'cle' => 'Vitesse Impression',
            'valeur' => '20 ppm',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_materiel' => 2,
            'cle' => 'Type',
            'valeur' => 'Laser',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    // ✅ Insertion en bulk
    CaracteristiqueSupplementaire::insert($caracteristiques);

    $notification = "Caractéristiques ajoutées avec succès";

    return $notification;
}
public function ajouterMouvements($type)
{
    $mouvements = [
        [
            'id_materiel' => 1, // id du matériel existant
            'type_mouvement' => $type,
            'emplacement_destination' => 1, // id de l'emplacement
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_materiel' => 2,
            'type_mouvement' => $type,
            'emplacement_destination' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_materiel' => 3,
            'type_mouvement' => $type,
            'emplacement_destination' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    // ✅ Insertion en bulk
    MouvementStock::insert($mouvements);

    $notification = "Mouvements ".$type." de stock ajoutés avec succès";

    return $notification ;
}
public function ajouterAffectations()
{
    $affectations = [
        [
            'id_materiel' => 1,
            'id_emplacement' => 1,
            'id_utilisateur' => 1,
            'date_affectation' => '2025-10-02',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_materiel' => 2,
            'id_emplacement' => 2,
            'id_utilisateur' => 2,
            'date_affectation' => '2025-10-02',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_materiel' => 3,
            'id_emplacement' => 1,
            'id_utilisateur' => 3,
            'date_affectation' => '2025-10-02',
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    // ✅ Insertion en bulk
    Affectation::insert($affectations);

    $notification = "Toutes les affectations ont été ajoutées avec succès";



    return $notification;
}

}
