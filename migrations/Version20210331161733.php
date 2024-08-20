<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331161733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, candidate_id_id INT NOT NULL, offre_id INT NOT NULL, etat VARCHAR(255) NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, date_postuler DATE NOT NULL, INDEX IDX_E33BD3B847A475AB (candidate_id_id), INDEX IDX_E33BD3B84CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE interview (id INT AUTO_INCREMENT NOT NULL, enteprise_id INT DEFAULT NULL, cand_id INT DEFAULT NULL, date_temps DATETIME NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, abreviation VARCHAR(4) DEFAULT NULL, INDEX IDX_CF1D3C34F3060E4C (enteprise_id), INDEX IDX_CF1D3C34EFDCE0A3 (cand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B847A475AB FOREIGN KEY (candidate_id_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE interview ADD CONSTRAINT FK_CF1D3C34F3060E4C FOREIGN KEY (enteprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE interview ADD CONSTRAINT FK_CF1D3C34EFDCE0A3 FOREIGN KEY (cand_id) REFERENCES candidature (id)');
        $this->addSql('ALTER TABLE categorieoffre ADD color VARCHAR(7) NOT NULL');
        $this->addSql('ALTER TABLE offre ADD iduser_id INT DEFAULT NULL, ADD enteprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FF3060E4C FOREIGN KEY (enteprise_id) REFERENCES entreprise (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F786A81FB ON offre (iduser_id)');
        $this->addSql('CREATE INDEX IDX_AF86866FF3060E4C ON offre (enteprise_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE interview DROP FOREIGN KEY FK_CF1D3C34EFDCE0A3');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE interview');
        $this->addSql('ALTER TABLE categorieoffre DROP color');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F786A81FB');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FF3060E4C');
        $this->addSql('DROP INDEX IDX_AF86866F786A81FB ON offre');
        $this->addSql('DROP INDEX IDX_AF86866FF3060E4C ON offre');
        $this->addSql('ALTER TABLE offre DROP iduser_id, DROP enteprise_id');
    }
}
