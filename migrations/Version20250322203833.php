<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322203833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fleet_set ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER INDEX uniq_fleet_set_truck RENAME TO UNIQ_49EA01EAC6957CCE');
        $this->addSql('ALTER INDEX uniq_fleet_set_trailer RENAME TO UNIQ_49EA01EAB6C04CFD');
        $this->addSql('ALTER INDEX idx_fleet_driver_fleet_set_id RENAME TO IDX_A1796F9BF0AA28');
        $this->addSql('ALTER INDEX idx_fleet_driver_driver_id RENAME TO IDX_A1796FC3423909');
        $this->addSql('ALTER TABLE service_order ADD order_number VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fleet_set DROP name');
        $this->addSql('ALTER INDEX uniq_49ea01eab6c04cfd RENAME TO uniq_fleet_set_trailer');
        $this->addSql('ALTER INDEX uniq_49ea01eac6957cce RENAME TO uniq_fleet_set_truck');
        $this->addSql('ALTER INDEX idx_a1796fc3423909 RENAME TO idx_fleet_driver_driver_id');
        $this->addSql('ALTER INDEX idx_a1796f9bf0aa28 RENAME TO idx_fleet_driver_fleet_set_id');
        $this->addSql('ALTER TABLE service_order DROP order_number');
    }
}
