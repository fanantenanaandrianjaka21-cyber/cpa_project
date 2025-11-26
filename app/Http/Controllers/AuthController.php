<?php

namespace App\Http\Controllers;

use App\Models\Codes_verification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function index(){
         $utilisateur = Auth::user(); 
// dd('test');
    try {

        $this->envoyerCodeVerification($utilisateur);

        // return "Email envoyé, l'adresse semble valide.";
    return redirect('/verifier-code')->with('success', 'Un code de verification a été envoyé à votre email.');

    } catch (\Exception $e) {
// dd($e);
        return "Échec : l'email n'existe probablement pas ou ne reçoit pas les mails.";
    }
    }
       public function envoyerCodeVerification(User $utilisateur)
{
    // Générer le code
    $code_verification = rand(100000, 999999);

    // Enregistrer en base
    Codes_verification::create([
        'utilisateur_id' => $utilisateur->id,
        'code'           => $code_verification,
        'expire_le'      => now()->addMinutes(15),
    ]);

    // Données envoyées au mail
    $donnees = [
        'nom_utilisateur' => $utilisateur->nom_utilisateur, // adapter selon ta colonne
        'code'            => $code_verification,
    ];
// $utilisateur->email='fanantenanaandrianjaka21@gmail.com';
    // Envoyer l'email
    Mail::to($utilisateur->email)
        ->send(new \App\Mail\EmailCodeVerification($donnees));
}
    public function afficherFormulaire2FA()
{
    return view('auth.verification_code');
}

public function verifierCode2FA(Request $requete)
{
    $requete->validate([
        'code' => 'required|numeric',
        'pin'  => 'required|digits:6',
    ]);

    $enregistrement = Codes_verification::where('utilisateur_id', auth()->id())
                                      ->where('code', $requete->code)
                                      ->first();

    if (!$enregistrement) {
        return back()->with('erreur', 'Code invalide.');
    }

    if ($enregistrement->estExpire()) {
        return back()->with('erreur', 'Le code a expiré.');
    }

    // if ($requete->pin != auth()->user()->pin) {
    if (!Hash::check($requete->pin, auth()->user()->pin)) {
        return back()->with('erreur', 'PIN incorrect.');
    }

    // Supprime le code utilisé
    $enregistrement->delete();
$requete->session()->put('2fa_valid', true);
    return redirect('/')->with('success', 'Connexion réussie.');
}

public function renvoyerCodeVerification()
{
    $utilisateur = auth()->user();
    $this->envoyerCodeVerification($utilisateur);

    return back()->with('success', 'Un nouveau code a été envoyé à votre email.');
}

}
