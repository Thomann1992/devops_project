<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\Mailer;
use App\Entity\User;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;
use DG\BypassFinals;

use Symfony\Component\Mailer\MailerInterface;

class MailerTest extends TestCase
{
    protected function setUp(): void
    {
        BypassFinals::enable();
    }


    public function testResetPasswordMail(): void
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);

        $user = new User();
        $user->setEmail("test@test.com");

        // $usermail = $user->getEmail();
        $token = $this->createMock(ResetPasswordToken::class);
        // $token = $this->resetPasswordHelper->generateResetToken($user);

        $mailer = new Mailer($symfonyMailer);
        $email = $mailer->resetPasswordMail($user, $token);
        
        // Tests if the subject is sent with the mail
        $this->assertSame('Your password reset request', $email->getSubject());
        
        // Tests that the mail is sent to exactly one recipient
        $this->assertCount(1, $email->getTo());

        // Tests if the recipient is the users username
        $addresses = $email->getTo();
        $this->assertSame('test@test.com', $addresses[0]->getAddress());
    
    }
}
