<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524175426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_bbc83db645c69330');
        $this->addSql('ALTER TABLE horaire ADD derniere_modification DATE DEFAULT CURRENT_DATE');
        $this->addSql('ALTER TABLE horaire DROP date_modification');
        $this->addSql('CREATE INDEX IDX_BBC83DB645C69330 ON horaire (type_horaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_BBC83DB645C69330');
        $this->addSql('ALTER TABLE horaire ADD date_modification DATE DEFAULT CURRENT_DATE');
        $this->addSql('ALTER TABLE horaire DROP derniere_modification');
        $this->addSql('ALTER TABLE horaire ALTER date_creation SET DEFAULT CURRENT_DATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_bbc83db645c69330 ON horaire (type_horaire_id)');
    }
}
