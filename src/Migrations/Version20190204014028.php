<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190204014028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE weathers_conditions (weather_id INT NOT NULL, weather_condition_id INT NOT NULL, INDEX IDX_E4C293A08CE675E (weather_id), INDEX IDX_E4C293A086C2CF78 (weather_condition_id), PRIMARY KEY(weather_id, weather_condition_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE weathers_conditions ADD CONSTRAINT FK_E4C293A08CE675E FOREIGN KEY (weather_id) REFERENCES weather (id)');
        $this->addSql('ALTER TABLE weathers_conditions ADD CONSTRAINT FK_E4C293A086C2CF78 FOREIGN KEY (weather_condition_id) REFERENCES weather_condition (id)');
        $this->addSql('ALTER TABLE weather ADD place_id INT DEFAULT NULL, DROP weather_conditions, DROP place');
        $this->addSql('ALTER TABLE weather ADD CONSTRAINT FK_4CD0D36EDA6A219 FOREIGN KEY (place_id) REFERENCES place (id)');
        $this->addSql('CREATE INDEX IDX_4CD0D36EDA6A219 ON weather (place_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE weathers_conditions');
        $this->addSql('ALTER TABLE weather DROP FOREIGN KEY FK_4CD0D36EDA6A219');
        $this->addSql('DROP INDEX IDX_4CD0D36EDA6A219 ON weather');
        $this->addSql('ALTER TABLE weather ADD weather_conditions LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', ADD place INT NOT NULL, DROP place_id');
    }
}
