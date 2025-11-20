<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TicketStatusController;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



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

// Route::get('/a', function () {
//     return view('dashboard.test');
// });



// Auth::routes();
Auth::routes(['register' => false]);
/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/inscription', [App\Http\Controllers\UserController::class, 'index'])->middleware('auth')->name('user.index');
Route::post('/ajoutUser', [App\Http\Controllers\UserController::class, 'ajoutUser'])->middleware('auth')->name('ajoutUser');
Route::get('/listUser/{id_emplacement},{role}', [App\Http\Controllers\UserController::class, 'listUser'])->middleware('auth')->name('user.liste');
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
Route::post("utilisateur/import", [App\Http\Controllers\SimpleExcelController::class, 'importUtilisateur'])->middleware('auth')->name('utilisateurexcel.import');
Route::post("etatmateriel/import", [App\Http\Controllers\SimpleExcelController::class, 'importEtatmateriel'])->middleware('auth')->name('etatmaterielexcel.import');

// Exporter un fichier Excel
Route::post("simple-excel/export", [App\Http\Controllers\SimpleExcelController::class, 'export'])->middleware('auth')->name('excel.export');
Route::post("inventaire/export", [App\Http\Controllers\SimpleExcelController::class, 'exportInventaire'])->middleware('auth')->name('inventaireexcel.export');
Route::post("mouvement/export", [App\Http\Controllers\SimpleExcelController::class, 'exportMouvement'])->middleware('auth')->name('mouvementexcel.export');

Route::get('/import', function () {
    return view('excel.import');
});
Route::get('/export', function () {
    return view('excel.export');
});

// ***************route materiel*************//
Route::get('/gestionMateriels/{id_emplacement},{role}', [App\Http\Controllers\MaterielController::class, 'index'])->middleware('auth')->name('gestionMateriels');
Route::get('/tousLesMateriels/{id_emplacement},{role}', [App\Http\Controllers\MaterielController::class, 'afficheMateriels'])->middleware('auth')->name('tousLesMateriels');
Route::get('/partype_centre/{type}', [App\Http\Controllers\MaterielController::class, 'afficheMaterielspartype_centre'])->middleware('auth')->name('materiel.partype_centre');
Route::get('/partype_par_centre/{type},{id_emplacement}', [App\Http\Controllers\MaterielController::class, 'afficheMaterielspartype_par_centre'])->middleware('auth')->name('materiel.partype_par_centre');
Route::post('/modifierMateriels', [App\Http\Controllers\MaterielController::class, 'modifierMateriel'])->middleware('auth')->name('materiel.modifier');
Route::get('/detailsMateriels/{id}', [App\Http\Controllers\MaterielController::class, 'detailsMateriel'])->middleware('auth')->name('materiel.details');
Route::get('/editMateriels/{id}', [App\Http\Controllers\MaterielController::class, 'editMateriel'])->middleware('auth')->name('materiel.edit');
Route::get('/deleteMateriels/{id}', [App\Http\Controllers\MaterielController::class, 'delete'])->middleware('auth')->name('materiel.delete');
Route::post('/ajoutType', [App\Http\Controllers\TypeMaterielController::class, 'ajoutType'])->middleware('auth')->name('materiel.ajout_type');
Route::post('/ajoutMateriel', [App\Http\Controllers\MaterielController::class, 'ajoutMateriel'])->middleware('auth')->name('materiel.ajout_materiel');
Route::put('/materiels/distribuer', [App\Http\Controllers\MaterielController::class, 'distribuer'])->name('materiels.distribuer');

// **************route caracteristique supplementaire***********************//

Route::get('/voirCaracteristique/{id}/{page}', [App\Http\Controllers\CaracteristiqueSupplementaireController::class, 'voirCaracteristique'])->middleware('auth')->name('caracteristique.voir');

// ************mouvement stock************************//
Route::get('/listMouvement/{id_emplacement}/{role}', [App\Http\Controllers\MouvementStockController::class, 'listMouvement'])->middleware('auth')->name('mouvement.liste');
// ***********affectation****************//
Route::get('/affectation/{id}', [App\Http\Controllers\AffectationController::class, 'affectation'])->middleware('auth');
Route::post('/faireAffectation', [App\Http\Controllers\AffectationController::class, 'faireAffectation'])->middleware('auth')->name('affectation.faire');
//****************emplacement********** *//
Route::get('/listeEmplacement', [App\Http\Controllers\EmplacementController::class, 'listeEmplacement'])->middleware('auth')->name('listEmplacement');
Route::get('/formEmplacement', function () {
    $active_tab='emplacement';
    return view('emplacement.ajout',compact('active_tab'));
})->middleware('auth')->name('formEmplacement');
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
Route::post('/inventaire/modifier', [App\Http\Controllers\InventaireController::class, 'modifier'])->middleware('auth');

// ***********************mes donnees perso***********************//
Route::get('/DataEmplacement', [App\Http\Controllers\DataController::class, 'ajouterEmplacements']);
Route::get('/DataUtilisateur', [App\Http\Controllers\DataController::class, 'ajouterUtilisateurs']);
Route::get('/DataMateriel', [App\Http\Controllers\DataController::class, 'ajouterMateriels'])->middleware('auth');
Route::get('/DataCaracteristique', [App\Http\Controllers\DataController::class, 'ajouterCaracteristiques'])->middleware('auth');
Route::get('/DataMouvement/{typeMouvement}', [App\Http\Controllers\DataController::class, 'ajouterMouvements'])->middleware('auth');
Route::get('/DataAffectation', [App\Http\Controllers\DataController::class, 'ajouterAffectations'])->middleware('auth');

//*************ticketing******** */
// Route::get('/indextickes', function () {
//     return redirect('/tickets?active_tab=ticket')->with('active_tab', 'ticket');
// })->middleware('auth')->name('ticket');
Route::get('/listeTicket', [App\Http\Controllers\TicketController::class, 'listeTicketAdmin'])->middleware('auth')->name('listTicketAdmin');
Route::get('/formTicket', function () {
    $active_tab='ticketing';
    return view('ticketing.admin.ajout_ticket',compact('active_tab'));
})->middleware('auth')->name('formTicket');
Route::post('/ajoutTicket', [App\Http\Controllers\TicketController::class, 'ajouterTicket'])->middleware('auth')->name('Ticket.ajout');
Route::post('/modifierTicket', [App\Http\Controllers\TicketController::class, 'modifierTicket'])->middleware('auth')->name('Ticket.modifier');
Route::get('/detailsTicket/{id}', [App\Http\Controllers\TicketController::class, 'detailsTicket'])->middleware('auth')->name('Ticket.details');
Route::get('/editTicket/{id}', [App\Http\Controllers\TicketController::class, 'editTicket'])->middleware('auth')->name('Ticket.edit');
Route::get('/deleteTicket/{id}', [App\Http\Controllers\TicketController::class, 'delete'])->middleware('auth')->name('Ticket.delete');
Route::get('/detailsTicketTechnicien/{id}', [App\Http\Controllers\TicketController::class, 'detailsTicketTechnicien'])->middleware('auth')->name('TicketTechnicien.details');


// ************* Dashboard******************//
Route::get('/Dashboard', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth')->name('dashboard');

//********************TicketUtilisateur***********************//
Route::get('listeTicketUtilisateur', [App\Http\Controllers\TicketController::class, 'listeTicketUtilisateur'])->name('listeTicketUtilisateur');
Route::post('ajoutTicketUtilisateur', [App\Http\Controllers\TicketController::class, 'ajouterTicketUtilisateur'])->name('ajoutTicketUtilisateur');
// Route::get('listeTicketAassigner', [App\Http\Controllers\TicketController::class, 'TicketAassigner'])->name('listeTicketAassigner');
Route::get('ticketAassigner.ticket{id}', [App\Http\Controllers\TicketController::class, 'afficherFormulaireAssignation'])->name('ticketAassigner.ticket');
Route::post('ticketAassigner.ticket{id}', [App\Http\Controllers\TicketController::class, 'assignerTicket'])->name('tickets.assigner');
Route::get('ticketTraiter.ticket{id}', [App\Http\Controllers\TicketController::class, 'traiterTicket'])->name('tickets.traiter');
Route::post('ticketTerminer.ticket{id}', [App\Http\Controllers\TicketController::class, 'terminerTicket'])->name('tickets.terminer');

// ************* status du ticket*************//
Route::get('/admin/ticket-status/edit', [App\Http\Controllers\TicketStatusController::class, 'edit'])->name('ticket-status.edit');
Route::post('/admin/ticket-status/update', [App\Http\Controllers\TicketStatusController::class, 'update'])->name('ticket-status.update');
Route::get('/check-new-tickets', [App\Http\Controllers\TicketStatusController::class, 'checkNewTickets'])
    ->name('admin.checkNewTickets');

    // **************** Alert ********************//
    
Route::post('configurationAlert', [App\Http\Controllers\AlertController::class, 'ConfigureAlert'])->name('configureAlert');
Route::get('/alertes', [App\Http\Controllers\AlertController::class, 'index'])->name('alertes.index');
Route::post('/alertes/{id}/update', [App\Http\Controllers\AlertController::class, 'update'])->name('alertes.update');
Route::post('/alertes/{id}/updateDestinataire', [App\Http\Controllers\AlertController::class, 'updateDestinataire'])->name('alertes.updateDestinataire');
Route::post('/alertes/{id}/updateAlerteTypes', [App\Http\Controllers\AlertController::class, 'updateAlerteTypes'])->name('alertes.updateAlerteTypes');

//************************TicketTechnicien*************************//
Route::get('listeTicketTechnicien', [App\Http\Controllers\TicketController::class, 'listeTicketTechnicien'])->name('listeTicketTechnicien');
// Route::get('mailTechnicien', [App\Http\Mail::class, 'build'])->name('mailTechnicien');
// Route::get('mailTechicien', [App\Http\Controllers\TicketTechnicienController::class, 'mailTechnicien'])->name('mailTechnicien');
Route::get('resolution{id}', [App\Http\Controllers\TicketController::class, 'resolution'])->name('resolution');
// ****************** Maintenance *******************************//
Route::get('maintenanceMateriel/{id_ticket}/{id_materiel}', [App\Http\Controllers\MaintenanceController::class, 'affichePageMaintenance'])->name('maintenanceMateriel');
// ************************** Tache ************************//
Route::post('ajoutTache', [App\Http\Controllers\TacheController::class, 'AjoutTache'])->name('AjoutTache');
// ******************* configuration notification***********************//
Route::get('configurationNotification', [App\Http\Controllers\DashboardController::class, 'configurationNotification'])->name('configurationNotification');
Route::put('/alerte/{id}', [App\Http\Controllers\DashboardController::class, 'update'])->name('alerte.update');

// mail log
Route::get('/mail-logs', [App\Http\Controllers\MailLogController::class, 'index'])->name('mail.logs');
Route::get('/test-brevo', function () {
    Mail::raw('<h1>Test Brevo</h1>', function ($message) {
        $message->to('fanantenanaandrianjaka21@gmail.com');
        $message->subject('Test Brevo API');
    });

    return 'Email envoyé !';
});

// doit retourner 200

Route::get('/run-schedule', function () {
    Artisan::call('schedule:run');
    return 'OK';
});
