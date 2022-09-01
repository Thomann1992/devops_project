<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901082848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_department (user_id INT NOT NULL, department_id INT NOT NULL, PRIMARY KEY(user_id, department_id))');
        $this->addSql('CREATE INDEX IDX_6A7A2766A76ED395 ON user_department (user_id)');
        $this->addSql('CREATE INDEX IDX_6A7A2766AE80F5DF ON user_department (department_id)');
        $this->addSql('ALTER TABLE user_department ADD CONSTRAINT FK_6A7A2766A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_department ADD CONSTRAINT FK_6A7A2766AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE description ALTER created SET NOT NULL');
        $this->addSql('ALTER TABLE description ALTER updated SET NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649ae80f5df');
        $this->addSql('DROP INDEX idx_8d93d649ae80f5df');
        $this->addSql('ALTER TABLE "user" DROP department_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_department DROP CONSTRAINT FK_6A7A2766A76ED395');
        $this->addSql('ALTER TABLE user_department DROP CONSTRAINT FK_6A7A2766AE80F5DF');
        $this->addSql('DROP TABLE user_department');
        $this->addSql('ALTER TABLE description ALTER created DROP NOT NULL');
        $this->addSql('ALTER TABLE description ALTER updated DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649ae80f5df FOREIGN KEY (department_id) REFERENCES department (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8d93d649ae80f5df ON "user" (department_id)');
    }
}
