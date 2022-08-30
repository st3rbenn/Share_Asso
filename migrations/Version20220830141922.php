<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220830141922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE association (id INT AUTO_INCREMENT NOT NULL, association_name VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE deal (id INT AUTO_INCREMENT NOT NULL, material_id INT DEFAULT NULL, asso_id INT DEFAULT NULL, deal_createdat DATETIME DEFAULT NULL, deal_updatedat DATETIME DEFAULT NULL, INDEX IDX_E3FEC116E308AC6F (material_id), INDEX IDX_E3FEC116792C8628 (asso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE material (id INT AUTO_INCREMENT NOT NULL, asso_id INT DEFAULT NULL, material_name VARCHAR(50) DEFAULT NULL, material_description LONGTEXT DEFAULT NULL, material_img VARCHAR(255) DEFAULT NULL, material_createdat DATETIME DEFAULT NULL, material_updatedat DATETIME DEFAULT NULL, INDEX IDX_7CBE7595792C8628 (asso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, asso_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649792C8628 (asso_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116E308AC6F FOREIGN KEY (material_id) REFERENCES material (id)');
        $this->addSql('ALTER TABLE deal ADD CONSTRAINT FK_E3FEC116792C8628 FOREIGN KEY (asso_id) REFERENCES association (id)');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE7595792C8628 FOREIGN KEY (asso_id) REFERENCES association (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649792C8628 FOREIGN KEY (asso_id) REFERENCES association (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC116E308AC6F');
        $this->addSql('ALTER TABLE deal DROP FOREIGN KEY FK_E3FEC116792C8628');
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE7595792C8628');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649792C8628');
        $this->addSql('DROP TABLE association');
        $this->addSql('DROP TABLE deal');
        $this->addSql('DROP TABLE material');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
