<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\FleetSet;
use App\Entity\Truck;
use App\Entity\Trailer;
use App\Entity\Driver;
use Doctrine\ORM\EntityManagerInterface;

class FleetControllerTest extends WebTestCase
{
    private ?EntityManagerInterface $entityManager = null;
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient(); 

        $this->entityManager = $this->client->getContainer()
            ->get('doctrine')
            ->getManager();

        $truck = new Truck();
        $truck->setPlateNumber('TRK-001');

        $trailer = new Trailer();
        $trailer->setPlateNumber('TRL-001');
        $trailer->setRegistrationNumber('TRL-001');
        $trailer->setType('Tentinė');

        $driver = new Driver();
        $driver->setFirstName('Jonas');
        $driver->setLastName('Jonaitis');
        $driver->setLicenseNumber('D1234567');

        $fleetSet = new FleetSet();
        $fleetSet->setName('Test Fleet');
        $fleetSet->setTruck($truck);
        $fleetSet->setTrailer($trailer);
        $fleetSet->addDriver($driver);

        $this->entityManager->persist($truck);
        $this->entityManager->persist($trailer);
        $this->entityManager->persist($driver);
        $this->entityManager->persist($fleetSet);
        $this->entityManager->flush();
    }

    public function testGetFleetReturnsData(): void
    {
        $this->client->request('GET', '/api/fleets');
        $response = $this->client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertIsArray($responseData);
        $this->assertNotEmpty($responseData);

        $this->assertEquals('TRK-001', $responseData[0]['truck']['plateNumber']);
        $this->assertEquals('TRL-001', $responseData[0]['trailer']['registrationNumber']);
        $this->assertEquals('Jonas Jonaitis', $responseData[0]['drivers'][0]['name']);
    }

    public function testGetFleetReturns200(): void
    {
        $this->client->request('GET', '/api/fleets');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testEnvFileIsLoaded(): void
    {
        $envValue = $_ENV['TEST_ENV_VAR'] ?? $_SERVER['TEST_ENV_VAR'] ?? getenv('TEST_ENV_VAR');

        $this->assertEquals(
            'This is a test environment variable',
            $envValue ?: null,
            'The .env.test file is not being used or TEST_ENV_VAR is not available in test context.'
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $conn = $this->entityManager->getConnection();
        $platform = $conn->getDatabasePlatform();

        $conn->executeStatement('SET session_replication_role = replica');
        $conn->executeStatement($platform->getTruncateTableSQL('fleet_set_driver', true));
        $conn->executeStatement($platform->getTruncateTableSQL('fleet_set', true));
        $conn->executeStatement($platform->getTruncateTableSQL('truck', true));
        $conn->executeStatement($platform->getTruncateTableSQL('trailer', true));
        $conn->executeStatement($platform->getTruncateTableSQL('driver', true));
        $conn->executeStatement('SET session_replication_role = origin');

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
