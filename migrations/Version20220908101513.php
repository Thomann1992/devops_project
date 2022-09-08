<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908101513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE description ADD created_by VARCHAR(255)');
        $this->addSql('ALTER TABLE description ADD updated_by VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ALTER created_by DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER updated_by DROP NOT NULL');
        $this->addSql('ALTER TABLE description DROP created_by');
        $this->addSql('ALTER TABLE description DROP updated_by');
        $this->addSql('ALTER TABLE department ALTER created_by DROP NOT NULL');
        $this->addSql('ALTER TABLE department ALTER updated_by DROP NOT NULL');
    }
}
