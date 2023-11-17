<?php

namespace App\Tests\Entity;

use App\Entity\Dorm;
use App\Entity\History;
use App\Entity\Machine;
use PHPUnit\Framework\TestCase;

class MachineTest extends TestCase
{
    public function testAddRemoveHistory(): void
    {
        $machine = new Machine();
        $history = new History();

        $machine->addHistory($history);
        $this->assertCount(1, $machine->getHistory());

        $machine->removeHistory($history);
        $this->assertCount(0, $machine->getHistory());
    }
}
