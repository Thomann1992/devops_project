<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserCrudControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertResponseStatusCodeSame(200);
    }
}
