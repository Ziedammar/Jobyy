<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331130745 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidate_commentaire (candidate_id INT NOT NULL, commentaire_id INT NOT NULL, INDEX IDX_A6A3B20091BD8781 (candidate_id), INDEX IDX_A6A3B200BA9CD190 (commentaire_id), PRIMARY KEY(candidate_id, commentaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate_commentaire ADD CONSTRAINT FK_A6A3B20091BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidate_commentaire ADD CONSTRAINT FK_A6A3B200BA9CD190 FOREIGN KEY (commentaire_id) REFERENCES commentaire (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE candidate_commentaire');
    }
}
