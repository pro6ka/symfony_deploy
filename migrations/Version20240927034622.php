<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240927034622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS fixation_user (user_id BIGINT NOT NULL, fixation_id BIGINT NOT NULL, PRIMARY KEY(user_id, fixation_id))');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_5522E340A76ED395 ON fixation_user (user_id)');
        $this->addSql('CREATE UNIQUE INDEX fixation_user__fixation_id_unique ON fixation_user (fixation_id)');
        $this->addSql('CREATE TABLE IF NOT EXISTS fixation_group (group_id BIGINT NOT NULL, fixation_id BIGINT NOT NULL, PRIMARY KEY(group_id, fixation_id))');
        $this->addSql('CREATE INDEX IDX_14C44D54FE54D947 ON fixation_group (group_id)');
        $this->addSql('CREATE UNIQUE INDEX fixation_group__fixation_id__unique ON fixation_group (fixation_id)');
        $this->addSql('ALTER TABLE fixation_user ADD CONSTRAINT fixation_user__user_id__fixation__id_fk FOREIGN KEY (user_id) REFERENCES fixation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation_user ADD CONSTRAINT fixation_user__fixation_id__fixation__id_fk FOREIGN KEY (fixation_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation_group ADD CONSTRAINT fixation_group__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES fixation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation_group ADD CONSTRAINT fixation_group__fixation_id__group__id_fk FOREIGN KEY (fixation_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation DROP CONSTRAINT IF EXISTS fixation__user_id__user__id_fk');
        $this->addSql('ALTER TABLE fixation DROP CONSTRAINT IF EXISTS fixation__group_id__group__id_fk');
        $this->addSql('DROP INDEX IF EXISTS fixation_user_id_unique');
        $this->addSql('DROP INDEX IF EXISTS fixation_group_id_unique');
        $this->addSql('ALTER TABLE fixation DROP user_id');
        $this->addSql('ALTER TABLE fixation DROP group_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fixation_user DROP CONSTRAINT IF EXISTS fixation_user__user_id__fixation__id_fk');
        $this->addSql('ALTER TABLE fixation_user DROP CONSTRAINT IF EXISTS fixation_user__fixation_id__fixation__id_fk');
        $this->addSql('ALTER TABLE fixation_group DROP CONSTRAINT IF EXISTS fixation_group__group_id__group__id_fk');
        $this->addSql('ALTER TABLE fixation_group DROP CONSTRAINT IF EXISTS fixation_group__fixation_id__group__id_fk');
        $this->addSql('DROP TABLE IF EXISTS fixation_user');
        $this->addSql('DROP TABLE IF EXISTS fixation_group');
        $this->addSql('ALTER TABLE fixation ADD user_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE fixation ADD group_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE fixation ADD CONSTRAINT fixation__user_id__user__id_fk FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation ADD CONSTRAINT fixation__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX fixation_user_id_unique ON fixation (user_id)');
        $this->addSql('CREATE UNIQUE INDEX fixation_group_id_unique ON fixation (group_id)');
    }
}
