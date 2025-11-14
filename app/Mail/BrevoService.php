<?php

namespace App\Mail;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;

class BrevoService
{
    protected $apiInstance;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', env('BREVO_API_KEY'));

        $this->apiInstance = new TransactionalEmailsApi(null, $config);
    }

    public function sendEmail($to, $subject, $html)
    {
        $email = new SendSmtpEmail([
            'subject' => $subject,
            'htmlContent' => $html,
            'sender' => [
                'name' => 'Mon App',
                'email' => env('MAIL_FROM_ADDRESS'),
            ],
            'to' => [
                ['email' => $to],
            ],
        ]);

        return $this->apiInstance->sendTransacEmail($email);
    }
}
