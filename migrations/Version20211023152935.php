<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211023152935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE produit_distributeur');
        $this->addSql('ALTER TABLE reference ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reference ADD CONSTRAINT FK_AEA34913F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AEA34913F347EFB ON reference (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE produit_distributeur (produit_id INT NOT NULL, distributeur_id INT NOT NULL, INDEX IDX_E3D5370CF347EFB (produit_id), INDEX IDX_E3D5370C29EB7ACA (distributeur_id), PRIMARY KEY(produit_id, distributeur_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE produit_distributeur ADD CONSTRAINT FK_E3D5370C29EB7ACA FOREIGN KEY (distributeur_id) REFERENCES distributeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produit_distributeur ADD CONSTRAINT FK_E3D5370CF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reference DROP FOREIGN KEY FK_AEA34913F347EFB');
        $this->addSql('DROP INDEX UNIQ_AEA34913F347EFB ON reference');
        $this->addSql('ALTER TABLE reference DROP produit_id');
    }
}
