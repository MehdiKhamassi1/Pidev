<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    
    public function __construct(private MailerInterface $mailer) {
        
        $this->mailer = $mailer;
    }
    public function sendEmail(
        $to = '',
        $content = '',
        $subject = 'Merci pour votre généreuse donation',
        $pdf=''
    ): void
    {
        $email = (new Email())
            ->from('notreatment.noreply@gmail.com')
            ->to($to)
            ->subject($subject)
            ->html($content)
            ->attachFromPath($pdf);
             $this->mailer->send($email);
       
    }
}