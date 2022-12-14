<?php

namespace App\tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();
        // $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = new User();
        $testUser->setEmail('bo@bo.com');
        $testUser->setPassword('123123');

        $testUserAdmin = new User();
        $testUserAdmin->setRoles(['ROLE_ADMIN']);

        // test that a user gets the role of ROLE_USER by default
        $this->assertEquals(['ROLE_USER'], $testUser->getRoles());

        // test that a user can have several roles and that the setter works as intended
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $testUserAdmin->getRoles());
    }
}
