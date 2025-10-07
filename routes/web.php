<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/a', function () {
    return view('welcome');
});

use App\Http\Controllers\Auth\RegisterController;


// Auth::routes();
Auth::routes(['register' => false]);
/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/inscription', function () {
//     return view('users.ajout');
// })->middleware('auth')->name('inscription');
Route::get('/inscription', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth')->name('user.index');
Route::post('/ajoutUser', [App\Http\Controllers\UserController::class, 'ajoutUser'])->middleware('auth')->name('ajoutUser');
Route::get('/listUser', [App\Http\Controllers\UserController::class, 'listUser'])->middleware('auth')->name('user.liste');
Route::post('/modifierUtilisateur', [App\Http\Controllers\UserController::class, 'modifierUtilisateur'])->middleware('auth')->name('utilisateur.modifier');
Route::get('/detailsUtilisateur/{id}', [App\Http\Controllers\UserController::class, 'detailsUtilisateur'])->middleware('auth')->name('utilisateur.details');
Route::get('/editUtilisateur/{id}', [App\Http\Controllers\UserController::class, 'editUtilisateur'])->middleware('auth')->name('utilisateur.edit');
Route::get('/deleteUtilisateur/{id}', [App\Http\Controllers\UserController::class, 'delete'])->middleware('auth')->name('utilisateur.delete');
Route::get('/affichetableau', [App\Http\Controllers\TableauController::class, 'AfficheTableau'])->middleware('auth')->name('affichetableau');

Route::get('/mail', function () {
    $contact = [
        'nom' => 'Rafa',
        'email' => 'Rafa@chezlui.com',
        'message' => 'Je voulais vous dire que votre site est magnifique !'
    ];

    // Envoi du mail
    Mail::to('fanantenanaandrianjaka21@gmail.com')->send(new WelcomeMail($contact));

    // Affichage de la vue avec les mêmes données
    return view('emails.Welcomemail', ['contact' => $contact]);
});

// Importer un fichier Excel
Route::post("simple-excel/import", [App\Http\Controllers\SimpleExcelController::class, 'import'])->middleware('auth')->name('excel.import');

// Exporter un fichier Excel
Route::post("simple-excel/export", [App\Http\Controllers\SimpleExcelController::class, 'export'])->middleware('auth')->name('excel.export');

Route::get('/import', function () {
    return view('excel.import');
});
Route::get('/export', function () {
    return view('excel.export');
});

// ***************route materiel*************//
Route::get('/gestionMateriels', [App\Http\Controllers\MaterielController::class, 'index'])->middleware('auth')->name('gestionMateriels');
Route::get('/tousLesMateriels', [App\Http\Controllers\MaterielController::class, 'afficheMateriels'])->middleware('auth')->name('tousLesMateriels');
Route::get('/partype_centre/{type}', [App\Http\Controllers\MaterielController::class, 'afficheMaterielspartype_centre'])->middleware('auth')->name('materiel.partype_centre');
Route::post('/modifierMateriels', [App\Http\Controllers\MaterielController::class, 'modifierMateriel'])->middleware('auth')->name('materiel.modifier');
Route::get('/detailsMateriels/{id}', [App\Http\Controllers\MaterielController::class, 'detailsMateriel'])->middleware('auth')->name('materiel.details');
Route::get('/editMateriels/{id}', [App\Http\Controllers\MaterielController::class, 'editMateriel'])->middleware('auth')->name('materiel.edit');
Route::get('/deleteMateriels/{id}', [App\Http\Controllers\MaterielController::class, 'delete'])->middleware('auth')->name('materiel.delete');
Route::post('/ajoutType', [App\Http\Controllers\TypeMaterielController::class, 'ajoutType'])->middleware('auth')->name('materiel.ajout_type');
Route::post('/ajoutMateriel', [App\Http\Controllers\MaterielController::class, 'ajoutMateriel'])->middleware('auth')->name('materiel.ajout_materiel');
// **************route caracteristique supplementaire***********************//

Route::get('/voirCaracteristique/{id}', [App\Http\Controllers\CaracteristiqueSupplementaireController::class, 'voirCaracteristique'])->middleware('auth')->name('caracteristique.voir');

// ************mouvement stock************************//
Route::get('/listMouvement', [App\Http\Controllers\MouvementStockController::class, 'listMouvement'])->middleware('auth')->name('mouvement.liste');
// ***********affectation****************//
Route::get('/affectation/{id}', [App\Http\Controllers\AffectationController::class, 'affectation'])->middleware('auth');
Route::post('/faireAffectation', [App\Http\Controllers\AffectationController::class, 'faireAffectation'])->middleware('auth')->name('affectation.faire');
//****************emplacement********** *//
Route::get('/listeEmplacement', [App\Http\Controllers\EmplacementController::class, 'listeEmplacement'])->middleware('auth');
Route::get('/formEmplacement', function () {
    $active_tab='emplacement';
    return view('emplacement.ajout',compact('active_tab'));
});
Route::post('/ajoutEmplacement', [App\Http\Controllers\EmplacementController::class, 'ajouterEmplacement'])->middleware('auth')->name('emplacement.ajout');
Route::post('/modifierEmplacement', [App\Http\Controllers\EmplacementController::class, 'modifierEmplacement'])->middleware('auth')->name('emplacement.modifier');
Route::get('/detailsEmplacement/{id}', [App\Http\Controllers\EmplacementController::class, 'detailsEmplacement'])->middleware('auth')->name('emplacement.details');
Route::get('/editEmplacement/{id}', [App\Http\Controllers\EmplacementController::class, 'editEmplacement'])->middleware('auth')->name('emplacement.edit');
Route::get('/deleteEmplacement/{id}', [App\Http\Controllers\EmplacementController::class, 'delete'])->middleware('auth')->name('emplacement.delete');
// *********affectation************//
Route::get('/utilisateurs/par-emplacement/{id_emplacement}', [App\Http\Controllers\AffectationController::class, 'getUtilisateurs'])->middleware('auth');
Route::get('/listeAffectation', [App\Http\Controllers\AffectationController::class, 'listAffectation'])->middleware('auth')->name('affectation.liste');
// ***************localisation*****************//
Route::get('/localisation/{emplacement}', [App\Http\Controllers\EmplacementController::class, 'getMateriels'])->middleware('auth');
// ****************inventaire***********************//
Route::get('/inventaire', [App\Http\Controllers\InventaireController::class, 'index'])->middleware('auth')->name('inventaire.faire');
Route::get('/materiels/{id}/qrcode', [App\Http\Controllers\InventaireController::class, 'generateQr'])->middleware('auth');
Route::get('/inventaire/scan/{code}', [App\Http\Controllers\InventaireController::class, 'scanMateriel'])->middleware('auth');
Route::get('/inventaire/getColonnes/{id}', [App\Http\Controllers\InventaireController::class, 'getColonnes'])->middleware('auth');
Route::post('/inventaire/update/{id}', [App\Http\Controllers\InventaireController::class, 'updateEtat'])->middleware('auth');
Route::post('/inventaire/store', [App\Http\Controllers\InventaireController::class, 'store'])->middleware('auth');

// ***********************mes donnees perso***********************//
Route::get('/DataEmplacement', [App\Http\Controllers\DataController::class, 'ajouterEmplacements']);
Route::get('/DataUtilisateur', [App\Http\Controllers\DataController::class, 'ajouterUtilisateurs']);
Route::get('/DataMateriel', [App\Http\Controllers\DataController::class, 'ajouterMateriels']);
Route::get('/DataCaracteristique', [App\Http\Controllers\DataController::class, 'ajouterCaracteristiques']);
Route::get('/DataMouvement/{typeMouvement}', [App\Http\Controllers\DataController::class, 'ajouterMouvements']);
Route::get('/DataAffectation', [App\Http\Controllers\DataController::class, 'ajouterAffectations']);

//*************ticketing******** */
Route::get('/indextickes', function () {
    return redirect('/tickets?active_tab=ticket')->with('active_tab', 'ticket');
})->middleware('auth')->name('ticket');


