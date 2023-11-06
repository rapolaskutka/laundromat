<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\History;
use App\Entity\Machine;
use App\Repository\AdminRepository;
use App\Repository\MachineRepository;

class MachineTest extends ApiTestCase
{
    public function testGetMachines(): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);

        $response = $client->request('GET', '/api/machines', ['headers' => ['accept' => 'application/json']]);

        $this->assertResponseIsSuccessful();
    }

    public function testPostMachine(): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);

        $client->loginUser($user);

        $data = [
            'dorm' => "/api/dorms/1",
            'type' => 'test',
            'lastMaintenance' => '2023-11-04T10:08:46.810Z',
            'isActive' => true
        ];

        $response = $client->request(
            'POST',
            '/api/machines',
            ['headers' => ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json'], 'body' => json_encode($data)]
        );

        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider historyProvider
     */
    public function testPutMachine($history): void
    {
        $client = static::createClient();
        /** @var AdminRepository $userRepository */
        $userRepository = static::getContainer()->get(AdminRepository::class);
        /** @var MachineRepository $machineRepository */
        $machineRepository = static::getContainer()->get(MachineRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);
        $testMachine = $machineRepository->findOneBy(['type' => 'test']);

        $client->loginUser($user);

        $data = [
            'dorm' => '/api/dorms/' . $testMachine->getDorm()->getId(),
            'type' => 'test',
            'lastMaintenance' => '2023-12-04T10:08:46.810Z',
            'history' => [$history]
        ];

        $response = $client->request(
            'PATCH',
            '/api/machines/' . $testMachine->getId(),
            ['headers' => ['CONTENT_TYPE' => 'application/merge-patch+json', 'accept' => 'application/json'], 'body' => json_encode($data)]
        );

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['lastMaintenance' => '2023-12-04T10:08:46+02:00'], true);
    }

    public function historyProvider()
    {
        $history = new History();

        return $history;
    }

//    public function testDeleteUser()
//    {
//        $client = static::createClient();
//        /** @var AdminRepository $userRepository */
//        $userRepository = static::getContainer()->get(AdminRepository::class);
//        $user = $userRepository->findOneBy(['email' => 'admin@admin.ktu']);
//        $testUser = $userRepository->findOneBy(['email' => 'test@test.ktu']);
//
//        $client->loginUser($user);
//
//        $response = $client->request(
//            'DELETE',
//            '/api/users/' . $testUser->getId(),
//            ['headers' => ['CONTENT_TYPE' => 'application/json', 'accept' => 'application/json']]
//        );
//
//        $this->assertResponseIsSuccessful();
//    }
}
