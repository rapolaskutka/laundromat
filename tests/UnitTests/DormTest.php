<?php

namespace App\Tests\Entity;

use App\Entity\Dorm;
use App\Entity\Machine;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class DormTest extends TestCase
{
    private Dorm $dorm;

    protected function setUp(): void
    {
        $this->dorm = new Dorm();
    }

    public function testGetSetName(): void
    {
        $name = "Dorm A";
        $this->dorm->setName($name);
        $this->assertEquals($name, $this->dorm->getName());
    }

    public function testAddMachine(): void
    {
        $machine = new Machine();
        $this->dorm->addMachine($machine);

        $this->assertCount(1, $this->dorm->getMachines());
        $this->assertSame($this->dorm, $machine->getDorm());
    }

    public function testRemoveMachine(): void
    {
        $machine = new Machine();
        $this->dorm->removeMachine($machine);

        $this->assertCount(0, $this->dorm->getMachines());
        $this->assertNull($machine->getDorm());
    }

    public function testSetAdministrator(): void
    {
        $admin = new User();
        $this->dorm->setAdministrator($admin);

        $this->assertSame($admin, $this->dorm->getAdministrator());
    }

    public function testAddResident(): void
    {
        $resident = new User();
        $this->dorm->addResident($resident);

        $this->assertCount(1, $this->dorm->getResidents());
        $this->assertSame($this->dorm, $resident->getDorm());
    }

    public function testRemoveResident(): void
    {
        $resident = new User();

        $this->dorm->removeResident($resident);
        $this->assertCount(0, $this->dorm->getResidents());
        $this->assertNull($resident->getDorm());
    }

    public function testToString(): void
    {
        $name = "Dorm B";
        $this->dorm->setName($name);

        $this->assertEquals($name, $this->dorm->__toString());
    }
}
