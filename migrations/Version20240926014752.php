<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926014752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_fixation DROP CONSTRAINT IF EXISTS group_fixation__fixation_id__fixation__id_fk');
        $this->addSql('ALTER TABLE group_fixation DROP CONSTRAINT IF EXISTS group_fixation__group_id__group__id_fk');
        $this->addSql('ALTER TABLE fixation_user DROP CONSTRAINT IF EXISTS fixation_user__fixation_id__fixation__id_fk');
        $this->addSql('ALTER TABLE fixation_user DROP CONSTRAINT IF EXISTS fixation_user__user_id__user__id_fk');
        $this->addSql('DROP TABLE IF EXISTS group_fixation');
        $this->addSql('DROP TABLE IF EXISTS fixation_user');
        $this->addSql('ALTER TABLE fixation ADD IF NOT EXISTS user_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE fixation ADD IF NOT EXISTS group_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE fixation ADD CONSTRAINT fixation__user_id__user__id_fk FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation ADD CONSTRAINT fixation__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX fixation_group_id_unique ON fixation (group_id)');
        $this->addSql('CREATE UNIQUE INDEX fixation_user_id_unique ON fixation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS group_fixation (fixation_id BIGINT NOT NULL, group_id BIGINT NOT NULL, PRIMARY KEY(fixation_id, group_id))');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_ccaf1e1efe54d947 ON group_fixation (group_id)');
        $this->addSql('CREATE UNIQUE INDEX IF NOT EXISTS group_fixation__fixation_id_unique ON group_fixation (fixation_id)');
        $this->addSql('CREATE TABLE IF NOT EXISTS fixation_user (fixation_id BIGINT NOT NULL, user_id BIGINT NOT NULL, PRIMARY KEY(fixation_id, user_id))');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_5522e340a76ed395 ON fixation_user (user_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_5522e340c769d5e1 ON fixation_user (fixation_id)');
        $this->addSql('ALTER TABLE group_fixation ADD CONSTRAINT group_fixation__fixation_id__fixation__id_fk FOREIGN KEY (fixation_id) REFERENCES fixation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_fixation ADD CONSTRAINT group_fixation__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation_user ADD CONSTRAINT fixation_user__fixation_id__fixation__id_fk FOREIGN KEY (fixation_id) REFERENCES fixation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation_user ADD CONSTRAINT fixation_user__user_id__user__id_fk FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation DROP CONSTRAINT IF EXISTS fixation__group_id__group__id_fk');
        $this->addSql('ALTER TABLE fixation DROP CONSTRAINT IF EXISTS fixation__group_id__group__id_fk');
        $this->addSql('DROP INDEX IF EXISTS fixation_group_id_unique');
        $this->addSql('DROP INDEX IF EXISTS fixation_user_id_unique');
        $this->addSql('ALTER TABLE fixation DROP IF EXISTS user_id');
        $this->addSql('ALTER TABLE fixation DROP IF EXISTS group_id');
    }
}
