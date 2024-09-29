<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240929093724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS fixation_revision (fixation_id BIGINT NOT NULL, revision_id BIGINT NOT NULL, PRIMARY KEY(fixation_id, revision_id))');
        $this->addSql('CREATE INDEX IDX_471DB822C769D5E1 ON fixation_revision (fixation_id)');
        $this->addSql('CREATE INDEX IDX_471DB8221DFA7C8F ON fixation_revision (revision_id)');
        $this->addSql('ALTER TABLE fixation_revision ADD CONSTRAINT fixation_revision__fixation_id__fixation__id_fk FOREIGN KEY (fixation_id) REFERENCES fixation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation_revision ADD CONSTRAINT fixation_revision__revision_id__revision__id_fk FOREIGN KEY (revision_id) REFERENCES revision (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation DROP CONSTRAINT IF EXISTS fixation__revision_id__revision_id_fk');
        $this->addSql('DROP INDEX IF EXISTS fixation__revision_id__unique');
        $this->addSql('ALTER TABLE fixation DROP IF EXISTS revision_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fixation_revision DROP CONSTRAINT IF EXISTS fixation_revision__fixation_id__fixation__id_fk');
        $this->addSql('ALTER TABLE fixation_revision DROP CONSTRAINT IF EXISTS fixation_revision__revision_id__revision__id_fk');
        $this->addSql('DROP TABLE IF EXISTS fixation_revision');
        $this->addSql('ALTER TABLE fixation ADD IF NOT EXISTS revision_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE fixation ADD CONSTRAINT fixation__revision_id__revision_id_fk FOREIGN KEY (revision_id) REFERENCES revision (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX IF NOT EXISTS fixation__revision_id__unique ON fixation (revision_id)');
    }
}
