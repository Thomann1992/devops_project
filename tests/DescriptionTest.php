<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Description;


class DescriptionTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        // $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testDescription = new Description();
        $testDescription->setName('Some description');
        $testDescription->setDescription('This is a description of something');


        // simulate $testUser being logged in
        // $client->loginUser($testUser);


        // test e.g. the admin page
        $this->assertEquals(date('M d, Y'), $testDescription->getCreated());
    }
}
