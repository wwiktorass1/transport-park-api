<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250322092958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create necessary tables and constraints for transport park system';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE driver_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fleet_set_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE service_order_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE trailer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE truck_id_seq INCREMENT BY 1 MINVALUE 1 START 1');

        $this->addSql('CREATE TABLE driver (
            id INT NOT NULL,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            license_number VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('CREATE TABLE trailer (
            id INT NOT NULL,
            registration_number VARCHAR(255) NOT NULL,
            type VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('CREATE TABLE truck (
            id INT NOT NULL,
            plate_number VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('CREATE TABLE fleet_set (
            id INT NOT NULL,
            truck_id INT NOT NULL,
            trailer_id INT DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FLEET_SET_TRUCK ON fleet_set (truck_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FLEET_SET_TRAILER ON fleet_set (trailer_id)');

        $this->addSql('CREATE TABLE fleet_set_driver (
            fleet_set_id INT NOT NULL,
            driver_id INT NOT NULL,
            PRIMARY KEY(fleet_set_id, driver_id)
        )');
        $this->addSql('CREATE INDEX IDX_FLEET_DRIVER_FLEET_SET_ID ON fleet_set_driver (fleet_set_id)');
        $this->addSql('CREATE INDEX IDX_FLEET_DRIVER_DRIVER_ID ON fleet_set_driver (driver_id)');

        $this->addSql('CREATE TABLE service_order (
            id INT NOT NULL,
            fleet_set_id INT DEFAULT NULL,
            truck_id INT DEFAULT NULL,
            trailer_id INT DEFAULT NULL,
            description VARCHAR(255) NOT NULL,
            start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            status VARCHAR(50) NOT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql("COMMENT ON COLUMN service_order.created_at IS '(DC2Type:datetime_immutable)'");
        $this->addSql("COMMENT ON COLUMN service_order.updated_at IS '(DC2Type:datetime_immutable)'");

        $this->addSql('ALTER TABLE fleet_set ADD CONSTRAINT FK_FLEET_SET_TRUCK FOREIGN KEY (truck_id) REFERENCES truck (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fleet_set ADD CONSTRAINT FK_FLEET_SET_TRAILER FOREIGN KEY (trailer_id) REFERENCES trailer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fleet_set_driver ADD CONSTRAINT FK_DRIVER_FLEET_SET_ID FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fleet_set_driver ADD CONSTRAINT FK_DRIVER_DRIVER_ID FOREIGN KEY (driver_id) REFERENCES driver (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_order ADD CONSTRAINT FK_SERVICE_ORDER_FLEET_SET FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_order ADD CONSTRAINT FK_SERVICE_ORDER_TRUCK FOREIGN KEY (truck_id) REFERENCES truck (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE service_order ADD CONSTRAINT FK_SERVICE_ORDER_TRAILER FOREIGN KEY (trailer_id) REFERENCES trailer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE fleet_set_driver');
        $this->addSql('DROP TABLE service_order');
        $this->addSql('DROP TABLE fleet_set');
        $this->addSql('DROP TABLE truck');
        $this->addSql('DROP TABLE trailer');
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP SEQUENCE driver_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fleet_set_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE service_order_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE trailer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE truck_id_seq CASCADE');
    }
}
