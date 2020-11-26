<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124201652 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, isdeleted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, descriptif VARCHAR(255) NOT NULL, isdeleted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profil CHANGE isdeleted isdeleted TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6D6B297A4D60759 ON profil (libelle)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE groupe_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP INDEX UNIQ_E6D6B297A4D60759 ON profil');
        $this->addSql('ALTER TABLE profil CHANGE isdeleted isdeleted TINYINT(1) NOT NULL');
    }
}
