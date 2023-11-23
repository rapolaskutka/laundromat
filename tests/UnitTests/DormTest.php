<?php

namespace App\Tests\UnitTests;

use App\Entity\Dorm;
use App\Entity\Machine;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class DormTest extends TestCase
{
    private Dorm $dorm;

    protected function setUp(): void
    {
        $this->dorm = new Dorm();
    }

    public function testGetId()
    {
        $this->assertNull($this->dorm->getId());
    }

    public function testSetAndGetNames()
    {
        $name = 'Dorm Name';
        $this->dorm->setName($name);
        $this->assertSame($name, $this->dorm->getName());
    }

    public function testGetMachinesInitiallyEmpty()
    {
        $this->assertInstanceOf(Collection::class, $this->dorm->getMachines());
        $this->assertEmpty($this->dorm->getMachines());
    }

    public function testAddAndRemoveMachine()
    {
        $machine = new Machine();
        $this->dorm->addMachine($machine);
        $this->assertTrue($this->dorm->getMachines()->contains($machine));

        $this->dorm->removeMachine($machine);
        $this->assertFalse($this->dorm->getMachines()->contains($machine));
    }

    public function testGetResidentsInitiallyEmpty()
    {
        $this->assertInstanceOf(Collection::class, $this->dorm->getResidents());
        $this->assertEmpty($this->dorm->getResidents());
    }

    public function testAddAndRemoveResident()
    {
        $resident = new User();
        $this->dorm->addResident($resident);
        $this->assertTrue($this->dorm->getResidents()->contains($resident));

        $this->dorm->removeResident($resident);
        $this->assertFalse($this->dorm->getResidents()->contains($resident));
    }

    public function testSetAndGetAdministrator()
    {
        $admin = new User();
        $this->dorm->setAdministrator($admin);
        $this->assertSame($admin, $this->dorm->getAdministrator());
    }

    public function testToStringMethod()
    {
        $name = 'Dormitory';
        $this->dorm->setName($name);
        $this->assertSame($name, $this->dorm->__toString());
    }
}
