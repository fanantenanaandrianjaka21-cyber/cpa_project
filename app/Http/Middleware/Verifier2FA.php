<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Verifier2FA
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie si l'utilisateur est connecté
        if (Auth::check()) {

            // Vérifie si le 2FA est validé en session
            if (!$request->session()->get('2fa_valid', false)) {
                // Redirige vers la page de vérification du code
                return redirect('/mail-verifier-code');
            }
        }

        return $next($request);
    }
}
