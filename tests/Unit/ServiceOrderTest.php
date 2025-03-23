<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\ServiceOrder;
use App\Entity\FleetSet;
use App\Entity\Truck;
use App\Entity\Trailer;

class ServiceOrderTest extends TestCase
{
    public function testSetAndGetOrderNumber()
    {
        $order = new ServiceOrder();
        $order->setOrderNumber('SO2024');

        $this->assertEquals('SO2024', $order->getOrderNumber());
    }

    public function testSetAndGetStatus()
    {
        $order = new ServiceOrder();
        $order->setStatus('completed');

        $this->assertEquals('completed', $order->getStatus());
    }

    public function testSetAndGetDescription()
    {
        $order = new ServiceOrder();
        $order->setDescription('Oil change');

        $this->assertEquals('Oil change', $order->getDescription());
    }

    public function testSetAndGetStartDate()
    {
        $order = new ServiceOrder();
        $startDate = new \DateTime('2024-03-01 08:00:00');
        $order->setStartDate($startDate);

        $this->assertSame($startDate, $order->getStartDate());
    }

    public function testSetAndGetEndDate()
    {
        $order = new ServiceOrder();
        $endDate = new \DateTime('2024-03-02 17:00:00');
        $order->setEndDate($endDate);

        $this->assertSame($endDate, $order->getEndDate());
    }

    public function testSetAndGetFleetSet()
    {
        $order = new ServiceOrder();
        $fleetSet = new FleetSet();
        $order->setFleetSet($fleetSet);

        $this->assertSame($fleetSet, $order->getFleetSet());
    }

    public function testSetAndGetTruck()
    {
        $order = new ServiceOrder();
        $truck = new Truck();
        $order->setTruck($truck);

        $this->assertSame($truck, $order->getTruck());
    }

    public function testSetAndGetTrailer()
    {
        $order = new ServiceOrder();
        $trailer = new Trailer();
        $order->setTrailer($trailer);

        $this->assertSame($trailer, $order->getTrailer());
    }
}
