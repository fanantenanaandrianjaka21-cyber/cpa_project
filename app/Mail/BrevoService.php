<?php

namespace App\Mail;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;

class BrevoService
{
    public static function sendEmail($to, $subject, $htmlContent)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_API_KEY'));
        $apiInstance = new TransactionalEmailsApi(null, $config);

        $email = new SendSmtpEmail([
            'subject' => $subject,
            'htmlContent' => $htmlContent,
            'sender' => ['name' => 'Mon App', 'email' => env('MAIL_FROM_ADDRESS')],
            'to' => [['email' => $to]]
        ]);

        return $apiInstance->sendTransacEmail($email);
    }
}
