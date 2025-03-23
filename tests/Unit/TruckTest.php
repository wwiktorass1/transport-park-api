<?php

namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Truck;

class TruckTest extends TestCase
{
    public function testSetAndGetPlateNumber(): void
    {
        $truck = new Truck();
        $truck->setPlateNumber('ABC123');

        $this->assertEquals('ABC123', $truck->getPlateNumber());
    }
}
