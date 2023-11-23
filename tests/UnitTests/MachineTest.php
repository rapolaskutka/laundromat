<?php

namespace App\Tests\UnitTests;

use App\Entity\History;
use App\Entity\Machine;
use PHPUnit\Framework\TestCase;

class MachineTest extends TestCase
{
    public function testAddHistory(): void
    {
        $machine = new Machine();
        $history = new History();

        $machine->addHistory($history);
        $this->assertCount(1, $machine->getHistory());
    }

    public function testRemoveHistory(): void
    {
        $machine = new Machine();
        $history = new History();

        $machine->removeHistory($history);
        $this->assertCount(0, $machine->getHistory());
    }
}
