<?php

namespace App\tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Entity\Description;


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
