<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         // On récupère l'historique actuel (tableau d'URLs)
        $history = session('history', []);

        // Si on a une URL précédente et qu'elle n'est pas la même que la courante
        if ($request->headers->has('referer')) {
            $previous = $request->headers->get('referer');
            if (!in_array($previous, $history)) {
                $history[] = $previous;
            }
        }

        // On limite à 5 pages maximum
        if (count($history) > 5) {
            array_shift($history);
        }

        session(['history' => $history]);
        return $next($request);
    }
}
