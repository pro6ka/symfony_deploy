<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925034552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS group_fixation (fixation_id BIGINT NOT NULL, group_id BIGINT NOT NULL, PRIMARY KEY(fixation_id, group_id))');
        $this->addSql('CREATE UNIQUE INDEX IF NOT EXISTS group_fixation__fixation_id_unique ON group_fixation (fixation_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_CCAF1E1EFE54D947 ON group_fixation (group_id)');
        $this->addSql('ALTER TABLE group_fixation ADD CONSTRAINT group_fixation__fixation_id__fixation__id_fk FOREIGN KEY (fixation_id) REFERENCES fixation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_fixation ADD CONSTRAINT group_fixation__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_fixation DROP CONSTRAINT IF EXISTS group_fixation__group_id__group__id_fk');
        $this->addSql('ALTER TABLE group_fixation DROP CONSTRAINT IF EXISTS group_fixation__fixation_id__fixation__id_fk');
        $this->addSql('DROP TABLE IF EXISTS group_fixation');
    }
}
