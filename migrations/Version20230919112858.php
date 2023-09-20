<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919112858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE images_users (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie ADD data_card VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD images_users_id INT DEFAULT NULL, DROP profile_image_name, DROP updated_at');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C490C957 FOREIGN KEY (images_users_id) REFERENCES images_users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C490C957 ON user (images_users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C490C957');
        $this->addSql('DROP TABLE images_users');
        $this->addSql('ALTER TABLE categorie DROP data_card');
        $this->addSql('DROP INDEX UNIQ_8D93D649C490C957 ON user');
        $this->addSql('ALTER TABLE user ADD profile_image_name VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP images_users_id');
    }
}
