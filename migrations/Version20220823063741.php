<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823063741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE description_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE description (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, one_password VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE description_department (description_id INT NOT NULL, department_id INT NOT NULL, PRIMARY KEY(description_id, department_id))');
        $this->addSql('CREATE INDEX IDX_72F1364BD9F966B ON description_department (description_id)');
        $this->addSql('CREATE INDEX IDX_72F1364BAE80F5DF ON description_department (department_id)');
        $this->addSql('ALTER TABLE description_department ADD CONSTRAINT FK_72F1364BD9F966B FOREIGN KEY (description_id) REFERENCES description (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE description_department ADD CONSTRAINT FK_72F1364BAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE description_id_seq CASCADE');
        $this->addSql('ALTER TABLE description_department DROP CONSTRAINT FK_72F1364BD9F966B');
        $this->addSql('ALTER TABLE description_department DROP CONSTRAINT FK_72F1364BAE80F5DF');
        $this->addSql('DROP TABLE description');
        $this->addSql('DROP TABLE description_department');
    }
}
