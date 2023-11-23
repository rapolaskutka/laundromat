<?php

namespace App\Tests\UnitTests;

use App\Entity\History;
use App\Entity\User;
use App\Entity\Machine;
use PHPUnit\Framework\TestCase;
use DateTime;

class HistoryTest extends TestCase
{
    private $history;

    protected function setUp(): void
    {
        $this->history = new History();
    }

    public function testGetAndSetStartDate()
    {
        $date = new DateTime('2023-01-01');
        $this->history->setStartDate($date);
        $this->assertSame($date, $this->history->getStartDate());
    }

    public function testGetAndSetEndDate()
    {
        $date = new DateTime('2023-01-02');
        $this->history->setEndDate($date);
        $this->assertSame($date, $this->history->getEndDate());
    }

    public function testGetAndSetUser()
    {
        $user = new User();
        $this->history->setUser($user);
        $this->assertSame($user, $this->history->getUser());
    }

    public function testGetAndSetMachine()
    {
        $machine = new Machine();
        $this->history->setMachine($machine);
        $this->assertSame($machine, $this->history->getMachine());
    }

    public function testId()
    {
        $this->assertNull($this->history->getId());
    }
}
