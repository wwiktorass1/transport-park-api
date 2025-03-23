<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Driver;
use App\Entity\FleetSet;

class DriverTest extends TestCase
{
    public function testSetAndGetName()
    {
        $driver = new Driver();
        $driver->setName('Jonas Jonaitis');

        $this->assertEquals('Jonas Jonaitis', $driver->getName());
    }

    public function testSetAndGetLicenseNumber()
    {
        $driver = new Driver();
        $driver->setLicenseNumber('DL12345');

        $this->assertEquals('DL12345', $driver->getLicenseNumber());
    }

    public function testSetAndGetFirstName()
    {
        $driver = new Driver();
        $driver->setFirstName('Jonas');

        $this->assertEquals('Jonas', $driver->getFirstName());
    }

    public function testSetAndGetLastName()
    {
        $driver = new Driver();
        $driver->setLastName('Jonaitis');

        $this->assertEquals('Jonaitis', $driver->getLastName());
    }

    public function testAddAndRemoveFleetSet()
    {
        $driver = new Driver();
        $fleetSet = new FleetSet();

  
        $this->assertCount(0, $driver->getFleetSets());

   
        $driver->addFleetSet($fleetSet);
        $this->assertCount(1, $driver->getFleetSets());
        $this->assertTrue($driver->getFleetSets()->contains($fleetSet));

    
        $driver->removeFleetSet($fleetSet);
        $this->assertCount(0, $driver->getFleetSets());
    }
}
