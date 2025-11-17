<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailManager;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Forcer HTTPS en production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        $this->app->make(MailManager::class)->extend('brevo', function ($config) {
            $factory = new BrevoTransportFactory();

            $key = config('services.brevo.key');

            if (!$key) {
                throw new \Exception('La clé BREVO_API_KEY n’est pas définie correctement dans config/services.php');
            }

            // Host requis par Dsn, peut être "default"
            $dsn = new Dsn(
                'brevo+api',  // scheme
                'default',    // host obligatoire
                $key          // user = clé API
            );

            return $factory->create($dsn);
        });
    }
}
