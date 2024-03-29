<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Comment;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211110121619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD status VARCHAR(255)');
        $this->addSql("UPDATE comment SET status = '" . Comment::STATUS_PUBLISHED . "'");
        $this->addSql('ALTER TABLE comment ALTER COLUMN status SET NOT NULL');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP status');
    }
}
