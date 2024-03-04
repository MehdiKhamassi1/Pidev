<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerServicerec
{

    public function __construct(private MailerInterface $mailer) {

        $this->mailer = $mailer;
    }
    public function sendEmail(
        $content = '',
        $subject = 'Nouvelle réclamation!'
    ): void
    {
        $email = (new Email())
            ->from('notreatment.noreply@gmail.com')
            ->to('redblazers007@gmail.com')
            ->subject($subject)
            ->html($content);
             $this->mailer->send($email);

    }
}