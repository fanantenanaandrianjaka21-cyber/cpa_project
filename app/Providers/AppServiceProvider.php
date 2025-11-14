<?php
namespace App\Providers;
use App\Mail\Transport\BrevoTransport;
use Illuminate\Mail\MailManager;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
            $this->app->make(MailManager::class)->extend('brevo', function () {
        return new BrevoTransport(config('mail.brevo.key'));
    });
    }
}







