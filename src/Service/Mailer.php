<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

class Mailer
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function resetPasswordMail(User $user, ResetPasswordToken $resetToken): Email
    {
        $email = (new TemplatedEmail())
        ->from(new Address('test@mail.com', 'ITK Mail Bot'))
        ->to($user->getEmail())
        ->subject('Your password reset request')
        ->htmlTemplate('reset_password/email.html.twig')
        ->context([
            'resetToken' => $resetToken,
        ]);

        $this->mailer->send($email);

        return $email;
    }
}
