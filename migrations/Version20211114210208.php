<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211114210208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gig ADD city_id INT');
        $this->addSql('ALTER TABLE gig ADD CONSTRAINT FK_D53020A28BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql("INSERT INTO city VALUES(1, 'Wrocław')");
        $this->addSql('UPDATE gig SET city_id = 1');
        $this->addSql('ALTER TABLE gig ALTER COLUMN city_id SET NOT NULL');
        $this->addSql('CREATE INDEX IDX_D53020A28BAC62AF ON gig (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gig DROP CONSTRAINT FK_D53020A28BAC62AF');
        $this->addSql('DROP INDEX IDX_D53020A28BAC62AF');
        $this->addSql('ALTER TABLE gig DROP city_id');
    }
}
