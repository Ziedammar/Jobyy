<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331115840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_dislike (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_BBC4A9D15200282E (formation_id), INDEX IDX_BBC4A9D1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_like (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_FBBCA5F35200282E (formation_id), INDEX IDX_FBBCA5F3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_dislike ADD CONSTRAINT FK_BBC4A9D15200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE formation_dislike ADD CONSTRAINT FK_BBC4A9D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE formation_like ADD CONSTRAINT FK_FBBCA5F35200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE formation_like ADD CONSTRAINT FK_FBBCA5F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE categorie ADD color VARCHAR(7) DEFAULT NULL');
        $this->addSql('ALTER TABLE formation ADD backcolor VARCHAR(7) NOT NULL, ADD bordercolor VARCHAR(7) NOT NULL, ADD textcolor VARCHAR(7) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE formation_dislike');
        $this->addSql('DROP TABLE formation_like');
        $this->addSql('ALTER TABLE categorie DROP color');
        $this->addSql('ALTER TABLE formation DROP backcolor, DROP bordercolor, DROP textcolor');
    }
}
