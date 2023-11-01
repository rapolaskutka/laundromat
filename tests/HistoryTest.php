<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\AdminRepository;

class HistoryTest extends ApiTestCase
{
    public function testGetMachines(): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);

        $response = $client->request('GET', '/api/histories', ['headers' => ['accept' => 'application/json']]);

        $this->assertResponseIsSuccessful();
    }
}
