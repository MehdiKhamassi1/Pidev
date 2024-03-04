<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerServiceRdv
{

    public function __construct(private MailerInterface $mailer) {

        $this->mailer = $mailer;
    }
    public function sendEmail(
        $to = '',
        $content = '',
        $subject = ''
    ): void
    {
        $email = (new Email())
            ->from('notreatment.noreply@gmail.com')
            ->to($to)
            ->subject($subject)
            ->html($content);
             $this->mailer->send($email);

    }
}