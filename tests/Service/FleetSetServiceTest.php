<?php

namespace App\Tests\Service;

use App\Entity\FleetSet;
use App\Repository\FleetSetRepository;
use App\Service\FleetSetService;
use PHPUnit\Framework\TestCase;

class FleetSetServiceTest extends TestCase
{
    public function testGetByIdReturnsFleet(): void
    {
        $fleet = new FleetSet();
        $fleet->setName('Test Fleet');

        $repo = $this->createMock(FleetSetRepository::class);
        $repo->expects($this->once())
             ->method('find')
             ->with(1)
             ->willReturn($fleet);

        /** @var \App\Repository\FleetSetRepository&\PHPUnit\Framework\MockObject\MockObject $repo */
        $service = new FleetSetService($repo);

        $result = $service->getById(1);

        $this->assertInstanceOf(FleetSet::class, $result);
        $this->assertEquals('Test Fleet', $result->getName());
    }

    public function testGetByIdReturnsNullIfNotFound(): void
    {
        $repo = $this->createMock(FleetSetRepository::class);
        $repo->expects($this->once())
             ->method('find')
             ->with(99) 
             ->willReturn(null);

        /** @var \App\Repository\FleetSetRepository&\PHPUnit\Framework\MockObject\MockObject $repo */
        $service = new FleetSetService($repo);

        $result = $service->getById(99);

        $this->assertNull($result);
    }
}