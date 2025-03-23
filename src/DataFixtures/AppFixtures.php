<?php

namespace App\DataFixtures;

use App\Entity\FleetSet;
use App\Entity\Truck;
use App\Entity\Trailer;
use App\Entity\Driver;
use App\Entity\ServiceOrder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $driver1 = new Driver();
        $driver1->setFirstName('Jonas')->setLastName('Jonaitis')->setLicenseNumber('ABC123');

        $driver2 = new Driver();
        $driver2->setFirstName('Petras')->setLastName('Petraitis')->setLicenseNumber('DEF456');

        $truck1 = new Truck();
        $truck1->setPlateNumber('TRK-001');

        $truck2 = new Truck();
        $truck2->setPlateNumber('TRK-002');

        $trailer1 = new Trailer();
        $trailer1->setRegistrationNumber('TRL-001')->setType('Tentinė');

        $trailer2 = new Trailer();
        $trailer2->setRegistrationNumber('TRL-002')->setType('Platforma');


        $fleet1 = new FleetSet();
        $fleet1->setName('Fleet A');
        $fleet1->setTruck($truck1);
        $fleet1->setTrailer($trailer1);
        $fleet1->addDriver($driver1);


        $truck1->setFleetSet($fleet1);
        $trailer1->setFleetSet($fleet1);


        $fleet2 = new FleetSet();
        $fleet2->setName('Fleet B');
        $fleet2->setTruck($truck2);
        $fleet2->setTrailer($trailer2);
        $fleet2->addDriver($driver2);
        

        $truck2->setFleetSet($fleet2);
        $trailer2->setFleetSet($fleet2);


        $order1 = new ServiceOrder();
        $order1->setDescription('Stabdžių patikra')
            ->setStartDate(new \DateTimeImmutable('-2 days'))
            ->setEndDate(new \DateTimeImmutable('-1 day'))
            ->setStatus('completed')
            ->setFleetSet($fleet1)
            ->setCreatedAt(new \DateTimeImmutable('-2 days'))
            ->setOrderNumber('ORD-001');

        $order2 = new ServiceOrder();
        $order2->setDescription('Alyvos keitimas')
            ->setStartDate(new \DateTimeImmutable())
            ->setStatus('in_progress')
            ->setFleetSet($fleet2)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setOrderNumber('ORD-002');


        foreach ([$driver1, $driver2, $truck1, $truck2, $trailer1, $trailer2, $fleet1, $fleet2, $order1, $order2] as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
