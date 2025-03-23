<?php
namespace App\Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Entity\Trailer;

class TrailerTest extends TestCase
{
    public function testSetAndGetRegistrationNumber()
    {
        $trailer = new Trailer();
        $trailer->setRegistrationNumber('TR1234');

        $this->assertEquals('TR1234', $trailer->getRegistrationNumber());
    }
}
