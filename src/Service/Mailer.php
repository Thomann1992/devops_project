<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use App\Entity\User;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordRequestFormType;
use App\Service\Mailer\Mailer as MailerMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer as ComponentMailerMailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;


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


