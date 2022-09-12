<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class UserTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        // $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = new User();
        $testUser->setEmail('bo@bo.com');
        $testUser->setPassword('123123');

        $testUserAdmin = new User();
        $testUserAdmin->setRoles(['ROLE_ADMIN']);


        // simulate $testUserAdmin being logged in
        $client->loginUser($testUserAdmin);
        $testUser->setEmail('bob@bob.com');


        // test that a user gets the role of ROLE_USER by default
        $this->assertEquals(['ROLE_USER'], $testUser->getRoles());

        // test that a user can have several roles and that the setter works as intended
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $testUserAdmin->getRoles());

        // $this->assertEquals($testUserAdmin, $testUser->getupdatedBy());
        //$this->assertEquals('bob@bob.com', $testUser->getEmail());


        // $client->request('GET', '/admin');
        // $this->assertResponseIsSuccessful();
        // $this->assertResponseStatusCodeSame('200', $crawler->$client->requst('GET', '/admin'));
        // $this->assertResponseStatusCodeSame(500);
    }
}
