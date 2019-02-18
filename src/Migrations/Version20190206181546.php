<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190206181546 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'CREATE TABLE weather_condition (
                  id INT NOT NULL, 
                  main VARCHAR(255) NOT NULL, 
                  description VARCHAR(255) NOT NULL, 
                  icon VARCHAR(255) NOT NULL, PRIMARY KEY(id)
                  ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE weather (
                id INT AUTO_INCREMENT NOT NULL,
                place_id INT DEFAULT NULL,
                added DATETIME NOT NULL,
                temperature NUMERIC(5, 2) NOT NULL,
                pressure INT NOT NULL,
                humidity INT NOT NULL,
                temperature_min NUMERIC(5, 2) NOT NULL,
                temperature_max NUMERIC(5, 2) NOT NULL,
                visibility INT NOT NULL,
                wind_speed NUMERIC(5, 2) NOT NULL,
                clouds INT NOT NULL,
                INDEX IDX_4CD0D36EDA6A219 (place_id),
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE weathers_conditions (
                weather_id INT NOT NULL,
                weather_condition_id INT NOT NULL,
                INDEX IDX_E4C293A08CE675E (weather_id),
                INDEX IDX_E4C293A086C2CF78 (weather_condition_id),
                PRIMARY KEY(weather_id, weather_condition_id)
             ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE weather_forecast (
                id INT AUTO_INCREMENT NOT NULL,
                place_id INT DEFAULT NULL,
                date DATETIME NOT NULL,
                temperature NUMERIC(5, 2) NOT NULL,
                wind_speed NUMERIC(5, 2) NOT NULL,
                snow NUMERIC(6, 2) DEFAULT NULL,
                rain NUMERIC(6, 2) DEFAULT NULL,
                clouds INT NOT NULL,
                INDEX IDX_CB36DFBFDA6A219 (place_id),
                PRIMARY KEY(id)
              ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE place (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(255) NOT NULL,
                name_polish VARCHAR(255) NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE weather ADD CONSTRAINT FK_4CD0D36EDA6A219 FOREIGN KEY (place_id) REFERENCES place (id)'
        );
        $this->addSql(
            'ALTER TABLE weathers_conditions ADD CONSTRAINT FK_E4C293A08CE675E
            FOREIGN KEY (weather_id) REFERENCES weather (id)'
        );
        $this->addSql(
            'ALTER TABLE weathers_conditions ADD CONSTRAINT FK_E4C293A086C2CF78
            FOREIGN KEY (weather_condition_id) REFERENCES weather_condition (id)'
        );
        $this->addSql(
            'ALTER TABLE weather_forecast ADD CONSTRAINT FK_CB36DFBFDA6A219
            FOREIGN KEY (place_id) REFERENCES place (id)'
        );
        $this->addSql(
            'INSERT INTO weather_db.place
                (id, name, name_polish)
                VALUES(756135, \'Warsaw\', \'Warszawa\');'
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE weathers_conditions DROP FOREIGN KEY FK_E4C293A086C2CF78');
        $this->addSql('ALTER TABLE weathers_conditions DROP FOREIGN KEY FK_E4C293A08CE675E');
        $this->addSql('ALTER TABLE weather DROP FOREIGN KEY FK_4CD0D36EDA6A219');
        $this->addSql('ALTER TABLE weather_forecast DROP FOREIGN KEY FK_CB36DFBFDA6A219');
        $this->addSql('DROP TABLE weather_condition');
        $this->addSql('DROP TABLE weather');
        $this->addSql('DROP TABLE weathers_conditions');
        $this->addSql('DROP TABLE weather_forecast');
        $this->addSql('DROP TABLE place');
    }
}
