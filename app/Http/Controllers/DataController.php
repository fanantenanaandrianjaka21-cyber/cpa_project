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
            'id' => 1,
            'id_emplacement' => 2,
            'nom_utilisateur' => 'Super Admin',
            'prenom_utilisateur' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('mdptestmdp'),
            'equipe' => 'Administration',
            'societe' => 'Experts CPA',
            'role' => 'Super Admin',
            'contact_utilisateur' => '0321234567',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                [
            'id' => 2,
            'id_emplacement' => 2,
            'nom_utilisateur' => 'Admin IT',
            'prenom_utilisateur' => 'Admin IT',
            'email' => 'adminit@gmail.com',
            'password' => Hash::make('mdptestmdp'),
            'equipe' => 'Administration',
            'societe' => 'Experts CPA',
            'role' => 'Admin IT',
            'contact_utilisateur' => '0321234567',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                                [
                                                    'id' => 3,
            'id_emplacement' => 2,
            'nom_utilisateur' => 'Responsable Site',
            'prenom_utilisateur' => 'Responsable Site',
            'email' => 'responsablesite@gmail.com',
            'password' => Hash::make('mdptestmdp'),
            'equipe' => 'Administration',
            'societe' => 'Experts CPA',
            'role' => 'Responsable Site',
            'contact_utilisateur' => '0321234567',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                        [
                                            'id' => 4,
            'id_emplacement' => 2,
            'nom_utilisateur' => 'Technicien IT',
            'prenom_utilisateur' => 'Technicien IT',
            'email' => 'technicienit@gmail.com',
            'password' => Hash::make('mdptestmdp'),
            'equipe' => 'Administration',
            'societe' => 'Experts CPA',
            'role' => 'Technicien IT',
            'contact_utilisateur' => '0321234567',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                                                [
                                                    'id' => 5,
            'id_emplacement' => 2,
            'nom_utilisateur' => 'Utilisateur',
            'prenom_utilisateur' => 'Utilisateur',
            'email' => 'utilisateur@gmail.com',
            'password' => Hash::make('mdptestmdp'),
            'equipe' => 'Administration',
            'societe' => 'Experts CPA',
            'role' => 'Utilisateur',
            'contact_utilisateur' => '0321234567',
            'created_at' => now(),
            'updated_at' => now(),
        ],
                [
                    'id' => 6,
            'id_emplacement' => 2,
            'nom_utilisateur' => 'Andrianjaka',
            'prenom_utilisateur' => 'Fanantenana',
            'email' => 'sahala@gmail.com',
            'password' => Hash::make('qwertyuiop'),
            'equipe' => 'Administration',
            'societe' => 'Experts CPA',
            'role' => 'Super Admin',
            'contact_utilisateur' => '0334456987',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        // [
        //     'id' => 7,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'Randria',
        //     'prenom_utilisateur' => 'Jean',
        //     'email' => 'randria@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Equipe A',
        //     'societe' => 'Societe X',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0321234567',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        // [
        //     'id' => 8,
        //     'id_emplacement' => 4,
        //     'nom_utilisateur' => 'RALAMBOMANDIMBY Andomalala Antoine',
        //     'prenom_utilisateur' => 'Ando',
        //     'email' => 'ando@example.com',
        //     'password' => Hash::make('password456'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0339876543',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        // [
        //     'id' => 9,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RANDRIAMPARANY Kerena',
        //     'prenom_utilisateur' => 'Antsa',
        //     'email' => 'antsa@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Administration',
        //     'societe' => 'CPA',
        //     'role' => 'Responsable Site',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //         [
        //             'id' => 10,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'JOYICE Brondonne',
        //     'prenom_utilisateur' => 'Brondonne',
        //     'email' => 'brondonne@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //         [
        //             'id' => 11,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RAKOTONOMENJANAHARY Davidson',
        //     'prenom_utilisateur' => 'Erica',
        //     'email' => 'erica@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Comptastar',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //         [
        //             'id' => 12,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RAFANOMEZANTSOA Fanantenana E. D.',
        //     'prenom_utilisateur' => 'Fanantenana',
        //     'email' => 'fanantenana@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'MyU',
        //     'societe' => 'RFC',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                 [
        //                     'id' => 13,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RASOAFANIRY Viviane M. C.',
        //     'prenom_utilisateur' => 'Fanie',
        //     'email' => 'fanie@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                 [
        //                     'id' => 14,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'SOLOFOARIMANANA',
        //     'prenom_utilisateur' => 'Fanirisoa',
        //     'email' => 'fanirisoa@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                 [
        //                     'id' => 15,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RAMBELONOROMANANA  Faniriniaina Michel',
        //     'prenom_utilisateur' => 'Faniry',
        //     'email' => 'faniry@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                 [
        //                     'id' => 16,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RAKOTOSALAMA Manitra',
        //     'prenom_utilisateur' => 'Hariniaina',
        //     'email' => 'hariniaina@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                         [
        //                             'id' => 17,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RATSIMBA Lovanirina',
        //     'prenom_utilisateur' => 'Harivony',
        //     'email' => 'harivony@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                         [
        //                             'id' => 18,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'ANDRIANANTOANDRO F.',
        //     'prenom_utilisateur' => 'Henintsoa',
        //     'email' => 'henintsoa@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                         [
        //                             'id' => 19,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RAKOTONDRAINIBE Onintsoa Ianjanirina',
        //     'prenom_utilisateur' => 'Ianja',
        //     'email' => 'ianja@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                         [
        //                             'id' => 20,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'MANDIMBISOA N. E.',
        //     'prenom_utilisateur' => 'Jeannie',
        //     'email' => 'jeannie@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Audit',
        //     'societe' => 'CPA',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                         [
        //                             'id' => 21,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'Véronique',
        //     'prenom_utilisateur' => 'Mamisoa',
        //     'email' => 'mamisoa@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Myu',
        //     'societe' => 'RFC',
        //     'role' => 'Utilisateur',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
        //                                 [
        //                                     'id' => 22,
        //     'id_emplacement' => 2,
        //     'nom_utilisateur' => 'RATEFIARISON Olivah',
        //     'prenom_utilisateur' => 'Maherisoa',
        //     'email' => 'maherisoa@example.com',
        //     'password' => Hash::make('qwertyuiop'),
        //     'equipe' => 'Informatique',
        //     'societe' => 'CPA',
        //     'role' => 'Admin IT',
        //     'contact_utilisateur' => '0341239876',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ],
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
            'quantite' => '1',
            'code_interne' => '11111',
            'marque' => 'HP',
            'model' => 'EliteBook 840',
            'num_serie' => 'HP-123456',
            'status' => 'disponible',
            'image' => 'imageMateriel/pc1.jpg',
            'date_aquisition' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_emplacement' => 2,
            'type' => 'Imprimante',
            'quantite' => '1',
            'code_interne' => '11112',
            'marque' => 'Canon',
            'model' => 'i-SENSYS LBP6030',
            'num_serie' => 'CN-654321',
            'status' => 'utiliser',
            'image' => 'imageMateriel/printer1.jpg',
            'date_aquisition' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id_emplacement' => 1,
            'type' => 'Switch Réseau',
            'quantite' => '1',
            'code_interne' => '11113',
            'marque' => 'Cisco',
            'model' => 'SG350-10',
            'num_serie' => 'CISCO-987654',
            'status' => 'en maintenance',
            'image' => 'imageMateriel/switch1.jpg',
            'date_aquisition' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
                [
            'id_emplacement' => 1,
            'type' => 'Souris',
            'quantite' => '40',
            'code_interne' => '11114',
            'marque' => 'Lenovo',
            'model' => 'SG350-10',
            'num_serie' => 'dres-987654',
            'status' => 'disponible',
            'image' => 'imageMateriel/souris.jpg',
            'date_aquisition' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],      [
            'id_emplacement' => 3,
            'type' => 'Souris',
            'quantite' => '34',
            'code_interne' => '11115',
            'marque' => 'Lenovo',
            'model' => 'SG350-10',
            'num_serie' => 'dres-987654',
            'status' => 'disponible',
            'image' => 'imageMateriel/souris.jpg',
            'date_aquisition' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],      [
            'id_emplacement' => 4,
            'type' => 'Souris',
            'quantite' => '21',
            'code_interne' => '11116',
            'marque' => 'Hp',
            'model' => 'SG350-10',
            'num_serie' => 'dres-987654',
            'status' => 'disponible',
            'image' => 'imageMateriel/souris.jpg',
            'date_aquisition' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ],
        
    ];

    
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

    
    Affectation::insert($affectations);

    $notification = "Toutes les affectations ont été ajoutées avec succès";



    return $notification;
}

}
