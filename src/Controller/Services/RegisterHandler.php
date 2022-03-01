<?php

namespace App\Controller\Services;

use App\Entity\Usuario;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterHandler
{
    private $encoder;
    private $mailer;

    public function __construct(UserPasswordEncoderInterface $encoder, MailerInterface $mailer)
    {
        $this->encoder = $encoder;
        $this->mailer = $mailer;
    }

    public function encodePass(String $plainPass, Usuario $usuario): String
    {
        return $this->encoder->encodePassword($usuario, $plainPass);
    }

    public function sendVerificationEmail(String $usuarioEmail, int $usuarioId): void
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p><a href = "' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '?usuario=' . $usuarioId . '" >Activar Cuenta</a>');

        $this->mailer->send($email);
    }
}
