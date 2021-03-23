<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309075556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP secteur');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F12469DE2 FOREIGN KEY (category_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F12469DE2 ON offre (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F12469DE2');
        $this->addSql('DROP INDEX IDX_AF86866F12469DE2 ON offre');
        $this->addSql('ALTER TABLE offre ADD secteur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
