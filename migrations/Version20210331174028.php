<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331174028 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FFA5A9824 FOREIGN KEY (idcategorie_id) REFERENCES categorie_offre (id)');
        $this->addSql('CREATE INDEX IDX_AF86866FFA5A9824 ON offre (idcategorie_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FFA5A9824');
        $this->addSql('DROP TABLE categorie_offre');
        $this->addSql('DROP INDEX IDX_AF86866FFA5A9824 ON offre');
    }
}
