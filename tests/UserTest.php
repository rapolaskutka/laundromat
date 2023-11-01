<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\AdminRepository;

class UserTest extends ApiTestCase
{

    public function testBadAuth(): void
    {
        $response = static::createClient()->request('GET', '/api/users', ['headers' => ['accept' => 'application/json']]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testGetUsers(): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);


        $response = $client->request('GET', '/api/users', ['headers' => ['accept' => 'application/json']]);

        $this->assertResponseIsSuccessful();
    }
}
