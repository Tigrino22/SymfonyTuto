<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211023153343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reference DROP FOREIGN KEY FK_AEA34913F347EFB');
        $this->addSql('DROP INDEX UNIQ_AEA34913F347EFB ON reference');
        $this->addSql('ALTER TABLE reference DROP produit_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reference ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reference ADD CONSTRAINT FK_AEA34913F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AEA34913F347EFB ON reference (produit_id)');
    }
}
