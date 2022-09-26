<?php

namespace App\tests;

use App\Entity\Description;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();
        // $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testDescription = new Description();
        $testDescription->setDescription('This is a description of something');
        $testDescription->setName('Some description');

        $testUserAdmin = new User();
        $testUserAdmin->setRoles(['ROLE_ADMIN']);

        // simulate $testUser being logged in
        // $client->loginUser($testUserAdmin);

        // test e.g. the admin page
        $this->assertEquals(date('Js F Y'), $testDescription->getCreated());

        // $this->assertEquals($testUserAdmin, $testUser->getupdatedBy());
    }
}
