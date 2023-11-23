<?php

namespace App\Tests\IntegrationApiTest;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\AdminRepository;

class HistoryApiTest extends ApiTestCase
{
    public function testGetHistory(): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);

        $response = $client->request('GET', '/api/histories', ['headers' => ['accept' => 'application/json']]);

        $this->assertResponseIsSuccessful();
    }

    public function testPostHistory()
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);

        $data = [
            'startDate' => '2023-11-04T10:08:46.810Z',
            'endDate' => '2023-11-04T10:08:46.810Z',
            'user' => '/api/users/' . $user->getId(),
            'machine' => null
        ];

        $response = $client->request(
            'POST',
            '/api/histories',
            ['headers' => ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'], 'body' => json_encode($data)]
        );

        $this->assertResponseIsSuccessful();
    }
}
