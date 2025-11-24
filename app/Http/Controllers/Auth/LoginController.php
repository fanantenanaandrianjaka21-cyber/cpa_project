<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

// class LoginController extends Controller
// {
//     /*
//     |--------------------------------------------------------------------------
//     | Login Controller
//     |--------------------------------------------------------------------------
//     |
//     | This controller handles authenticating users for the application and
//     | redirecting them to your home screen. The controller uses a trait
//     | to conveniently provide its functionality to your applications.
//     |
//     */

//     use AuthenticatesUsers;

//     /**
//      * Where to redirect users after login.
//      *
//      * @var string
//      */
//     protected $redirectTo = RouteServiceProvider::HOME;

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('guest')->except('logout');
//     }
// }

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * On remplace le champ email par login
     */
    public function username()
    {
        return 'login';
    }

    /**
     * On détecte si l'utilisateur utilise un email ou un ID
     */
protected function credentials(Request $request)
{
    $login = $request->input('login');

    // 1. Vérifier si email
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        return [
            'email' => $login,
            'password' => $request->input('password'),
        ];
    }

    // 2. Vérifier si c'est un ID numérique
    if (ctype_digit($login)) {
        return [
            'id' => (int) $login, // Sécurisé
            'password' => $request->input('password'),
        ];
    }

    // 3. Sinon → pas email + pas ID → login impossible
    return [
        'id' => 0, // Aucun utilisateur n'a id=0 → safe & évite crash PostgreSQL
        'password' => $request->input('password'),
    ];
}


    /**
     * Validation du formulaire
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Retour personnalisé si l'utilisateur échoue à se connecter
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')], // "Identifiants incorrects."
        ]);
    }
}
