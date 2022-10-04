<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220930124857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, department_name VARCHAR(255) NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, url VARCHAR(255) NOT NULL, one_password VARCHAR(255) DEFAULT NULL, additional_info VARCHAR(255) DEFAULT NULL, created DATE NOT NULL, updated DATETIME NOT NULL, content_changed DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE description_department (description_id INT NOT NULL, department_id INT NOT NULL, INDEX IDX_72F1364BD9F966B (description_id), INDEX IDX_72F1364BAE80F5DF (department_id), PRIMARY KEY(description_id, department_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_department (user_id INT NOT NULL, department_id INT NOT NULL, INDEX IDX_6A7A2766A76ED395 (user_id), INDEX IDX_6A7A2766AE80F5DF (department_id), PRIMARY KEY(user_id, department_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE description_department ADD CONSTRAINT FK_72F1364BD9F966B FOREIGN KEY (description_id) REFERENCES description (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE description_department ADD CONSTRAINT FK_72F1364BAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_department ADD CONSTRAINT FK_6A7A2766A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_department ADD CONSTRAINT FK_6A7A2766AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE description_department DROP FOREIGN KEY FK_72F1364BD9F966B');
        $this->addSql('ALTER TABLE description_department DROP FOREIGN KEY FK_72F1364BAE80F5DF');
        $this->addSql('ALTER TABLE user_department DROP FOREIGN KEY FK_6A7A2766A76ED395');
        $this->addSql('ALTER TABLE user_department DROP FOREIGN KEY FK_6A7A2766AE80F5DF');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE description');
        $this->addSql('DROP TABLE description_department');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_department');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
