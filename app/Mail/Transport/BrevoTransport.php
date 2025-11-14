<?php

namespace App\Mail\Transport;

use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\SentMessage;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class BrevoTransport extends AbstractTransport
{
    protected $apiInstance;

    public function __construct(string $apiKey)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);
        $this->apiInstance = new TransactionalEmailsApi(new Client(), $config);
    }

    protected function doSend(SentMessage $message): void
    {
        $original = $message->getOriginalMessage();

        // 🔹 Destinataires depuis l’enveloppe Mailer (fonctionne toujours)
        $toAddresses = $message->getEnvelope()->getRecipients();
        $to = [];
        foreach ($toAddresses as $addr) {
            $to[] = [
                'email' => $addr->getAddress(),
                'name'  => $addr->getName() ?? '',
            ];
        }

        if (empty($to)) {
            throw new \Exception('Aucun destinataire trouvé pour l’email.');
        }

        // 🔹 Sujet
        $subject = $original->subject ?? 'No Subject';

        // 🔹 Contenu HTML et texte
        $htmlContent = $original->html ?? $original->text ?? '<p> </p>';
        $textContent = $original->text ?? strip_tags($htmlContent);

        $emailData = new SendSmtpEmail([
            'subject'     => $subject,
            'sender'      => [
                'name'  => config('mail.from.name'),
                'email' => config('mail.from.address'),
            ],
            'to'          => $to,
            'htmlContent' => $htmlContent,
            'textContent' => $textContent,
        ]);

        // 🔹 Envoi via API Brevo
        $this->apiInstance->sendTransacEmail($emailData);
    }

    public function __toString(): string
    {
        return 'brevo';
    }
}
