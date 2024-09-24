<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924022226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fixation_revision DROP CONSTRAINT IF EXISTS fixation_revision__fixation_id__fixation__id_fk');
        $this->addSql('ALTER TABLE fixation_revision DROP CONSTRAINT IF EXISTS fixation_revision__revision_id__revision_id_fk');
        $this->addSql('DROP TABLE IF EXISTS fixation_revision');
        $this->addSql('ALTER TABLE fixation ADD IF NOT EXISTS revision_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE fixation ADD CONSTRAINT fixation__revision_id__revision_id_fk FOREIGN KEY (revision_id) REFERENCES revision (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX IF NOT EXISTS fixation__revision_id__unique ON fixation (revision_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS fixation_revision (fixation_id BIGINT NOT NULL, revision_id BIGINT NOT NULL, PRIMARY KEY(fixation_id, revision_id))');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_471db8221dfa7c8f ON fixation_revision (revision_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_471db822c769d5e1 ON fixation_revision (fixation_id)');
        $this->addSql('ALTER TABLE fixation_revision ADD IF NOT EXISTS CONSTRAINT fixation_revision__fixation_id__fixation__id_fk FOREIGN KEY (fixation_id) REFERENCES fixation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation_revision ADD IF NOT EXISTS CONSTRAINT fixation_revision__revision_id__revision_id_fk FOREIGN KEY (revision_id) REFERENCES revision (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation DROP CONSTRAINT IF EXISTS FK_C59F52611DFA7C8F');
        $this->addSql('DROP INDEX IF EXISTS fixation__revision_id__unique');
        $this->addSql('ALTER TABLE fixation DROP IF EXISTS revision_id');
    }
}
