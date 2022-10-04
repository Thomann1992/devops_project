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

        // retrieve the test user
        $testDescription = new Description();
        $testDescription->setDescription('This is a description of something');
        $testDescription->setName('Some description');

        $testUserAdmin = new User();
        $testUserAdmin->setRoles(['ROLE_ADMIN']);
    }
}
