<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331095806 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, cat VARCHAR(255) NOT NULL, date DATE NOT NULL, contenu VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, nom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, mobile INT NOT NULL, commentaire VARCHAR(255) NOT NULL, date DATE NOT NULL, blog_id INT NOT NULL, rate INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, lieu INT DEFAULT NULL, entreprise_id INT DEFAULT NULL, nbr INT NOT NULL, par_id INT NOT NULL, ent_id INT NOT NULL, date DATE NOT NULL, description VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, datefin DATE NOT NULL, backcolor VARCHAR(255) NOT NULL, bordercolor VARCHAR(255) NOT NULL, textcolor VARCHAR(255) NOT NULL, INDEX IDX_3BAE0AA72F577D59 (lieu), INDEX IDX_3BAE0AA7A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, lieu VARCHAR(255) NOT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, eventid INT NOT NULL, date DATE NOT NULL, nom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, mobile INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant_event (participant_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_FA1BA31E9D1C3019 (participant_id), INDEX IDX_FA1BA31E71F7E88B (event_id), PRIMARY KEY(participant_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA72F577D59 FOREIGN KEY (lieu) REFERENCES map (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE participant_event ADD CONSTRAINT FK_FA1BA31E9D1C3019 FOREIGN KEY (participant_id) REFERENCES participant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_event ADD CONSTRAINT FK_FA1BA31E71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant_event DROP FOREIGN KEY FK_FA1BA31E71F7E88B');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA72F577D59');
        $this->addSql('ALTER TABLE participant_event DROP FOREIGN KEY FK_FA1BA31E9D1C3019');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE participant_event');
    }
}
