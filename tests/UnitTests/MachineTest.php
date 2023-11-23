<?php

namespace App\Tests\UnitTests;

use App\Entity\History;
use App\Entity\Machine;
use PHPUnit\Framework\TestCase;
use function Symfony\Component\Translation\t;

class MachineTest extends TestCase
{
    public function testType(): void
    {
        $machine = new Machine();

        $machine->setType('test_type');

        $this->assertEquals('test_type', $machine->getType());
    }
    public function testLastMaintenance(): void
    {
        $machine = new Machine();
        $date = new \DateTime();
        $machine->setLastMaintenance($date);

        $this->assertEquals($date, $machine->getLastMaintenance());
    }
    public function testAddHistory(): void
    {
        $machine = new Machine();
        $history = new History();

        $machine->addHistory($history);
        $this->assertCount(1, $machine->getHistory());
    }
    public function testIsActive(): void
    {
        $machine = new Machine();

        $machine->setIsActive(true);
        $this->assertTrue($machine->isIsActive());
    }

    public function testRemoveHistory(): void
    {
        $machine = new Machine();
        $history = new History();

        $machine->removeHistory($history);
        $this->assertCount(0, $machine->getHistory());
    }

    public function testId(): void
    {
        $machine = new Machine();

        $this->assertNull($machine->getId());
    }
}
