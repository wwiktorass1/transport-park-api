<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\FleetSet;
use App\Entity\Truck;
use App\Entity\Trailer;
use App\Entity\Driver;
use App\Entity\ServiceOrder;

class FleetSetTest extends TestCase
{
    public function testSetAndGetTruck()
    {
        $fleetSet = new FleetSet();
        $truck = new Truck();
        $fleetSet->setTruck($truck);

        $this->assertSame($truck, $fleetSet->getTruck());
    }

    public function testSetAndGetTrailer()
    {
        $fleetSet = new FleetSet();
        $trailer = new Trailer();
        $fleetSet->setTrailer($trailer);

        $this->assertSame($trailer, $fleetSet->getTrailer());
    }

    public function testAddAndRemoveDriver()
    {
        $fleetSet = new FleetSet();
        $driver = new Driver();

        $this->assertCount(0, $fleetSet->getDrivers());

        $fleetSet->addDriver($driver);
        $this->assertCount(1, $fleetSet->getDrivers());
        $this->assertTrue($fleetSet->getDrivers()->contains($driver));

        $fleetSet->removeDriver($driver);
        $this->assertCount(0, $fleetSet->getDrivers());
    }

    public function testAddAndRemoveServiceOrder()
    {
        $fleetSet = new FleetSet();
        $serviceOrder = new ServiceOrder();

        $this->assertCount(0, $fleetSet->getServiceOrders());

        $fleetSet->addServiceOrder($serviceOrder);
        $this->assertCount(1, $fleetSet->getServiceOrders());
        $this->assertTrue($fleetSet->getServiceOrders()->contains($serviceOrder));
        $this->assertSame($fleetSet, $serviceOrder->getFleetSet());

        $fleetSet->removeServiceOrder($serviceOrder);
        $this->assertCount(0, $fleetSet->getServiceOrders());
        $this->assertNull($serviceOrder->getFleetSet());
    }
}
