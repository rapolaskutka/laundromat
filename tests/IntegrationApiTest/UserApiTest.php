<?php

namespace App\Tests\IntegrationApiTest;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Repository\AdminRepository;

class UserApiTest extends ApiTestCase
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
    public function testPostUsers(): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);

        $data = [
            'email' => 'test@test.ktu',
            'roles' => ['ROLE_USER'],
            'dorm' => "/api/dorms/1",
            'password' => 'test',
        ];

        $response = $client->request(
            'POST',
            '/api/users',
            ['headers' => ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'], 'body' => json_encode($data)]
        );

        $this->assertResponseIsSuccessful();
    }

    public function testPutUsers(): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);
        $testUser = $userRepository->findOneBy(['email' => 'test@test.ktu']);

        $client->loginUser($user);

        $data = [
            'email' => $testUser->getEmail(),
            'roles' => $testUser->getRoles(),
            'dorm' => "/api/dorms/1",
            'history' => [],
        ];

        $response = $client->request(
            'PATCH',
            '/api/users/' . $testUser->getId(),
            ['headers' => ['CONTENT_TYPE' => 'application/merge-patch+json', 'accept' => 'application/json'], 'body' => json_encode($data)]
        );

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteUser()
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);
        $testUser = $userRepository->findOneBy(['email' => 'test@test.ktu']);

        $client->loginUser($user);

        $response = $client->request(
            'DELETE',
            '/api/users/' . $testUser->getId(),
            ['headers' => ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json']]
        );

        $this->assertResponseIsSuccessful();
    }
}
