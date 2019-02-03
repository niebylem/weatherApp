<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190203173322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Initial database migration';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(
            'CREATE TABLE weather_condition (
              id INT NOT NULL,
              main VARCHAR(255) NOT NULL,
              description VARCHAR(255) NOT NULL,
              icon VARCHAR(255) NOT NULL,
              PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE weather (
            id INT AUTO_INCREMENT NOT NULL,
            added DATETIME NOT NULL,
            weather_conditions LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\',
            temperature NUMERIC(5, 2) NOT NULL,
            pressure INT NOT NULL,
            humidity INT NOT NULL,
            temperature_min NUMERIC(5, 2) NOT NULL,
            temperature_max NUMERIC(5, 2) NOT NULL,
            visibility INT NOT NULL,
            wind_speed NUMERIC(5, 2) NOT NULL,
            clouds INT NOT NULL,
            place INT NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );

        $this->addSql(
            'CREATE TABLE place (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE weather_condition');
        $this->addSql('DROP TABLE weather');
        $this->addSql('DROP TABLE place');
    }
}
