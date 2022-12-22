<?php

namespace App\tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testUserClass()
    {
        // Create a new user the test user
        $testUser = new User();
        $testUser->setEmail('bo@bo.com');
        $testUser->setPassword('123123');

        $testUserAdmin = new User();
        $testUserAdmin->setRoles(['ROLE_ADMIN']);

        // Test that a user gets the role of ROLE_USER by default
        $this->assertEquals(['ROLE_USER'], $testUser->getRoles());

        // Test that a user can have several roles and that the setter works as intended
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $testUserAdmin->getRoles());

        // Tests that the users email is always lower string
        $testUser->setEmail('Bo@bO.com');
        $this->assertEquals('bo@bo.com', $testUser->getEmail());
    }
}
