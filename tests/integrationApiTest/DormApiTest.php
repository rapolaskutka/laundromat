<?php

namespace App\Tests\integrationApiTest;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\AdminRepository;

class DormApiTest extends ApiTestCase
{
    public function testGetDorm(): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);

        $response = $client->request('GET', '/api/dorms', ['headers' => ['accept' => 'application/json']]);

        $this->assertResponseIsSuccessful();
    }

    public function testPostDorm()
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);

        $data = [
            'name' => 'test',
            'user' => '/api/users/' . $user->getId(),
            'residents' => ['/api/users/' . $user->getId()]
        ];

        $response = $client->request(
            'POST',
            '/api/dorms',
            ['headers' => ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'], 'body' => json_encode($data)]
        );

        $this->assertResponseIsSuccessful();
    }
}
