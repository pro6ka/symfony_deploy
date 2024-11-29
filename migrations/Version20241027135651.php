<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241027135651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS work_shop_group (work_shop_id BIGINT NOT NULL, group_id BIGINT NOT NULL, PRIMARY KEY(work_shop_id, group_id))');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_B1B5B34498DD7CFF ON work_shop_group (work_shop_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_B1B5B344FE54D947 ON work_shop_group (group_id)');
        $this->addSql('ALTER TABLE work_shop_group ADD CONSTRAINT work_shop_group__work_shop_id__work_shop__id_fk FOREIGN KEY (work_shop_id) REFERENCES work_shop (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE work_shop_group ADD CONSTRAINT work_shop_group__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_work_shop DROP CONSTRAINT IF EXISTS group_work_shop__group_id__group__id_fk');
        $this->addSql('ALTER TABLE group_work_shop DROP CONSTRAINT IF EXISTS group_work_shop__work_shop_id__work_shop_id_fk');
        $this->addSql('DROP TABLE IF EXISTS group_work_shop');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS group_work_shop (group_id BIGINT NOT NULL, work_shop_id BIGINT NOT NULL, PRIMARY KEY(group_id, work_shop_id))');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_951aa17b98dd7cff ON group_work_shop (work_shop_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_951aa17bfe54d947 ON group_work_shop (group_id)');
        $this->addSql('ALTER TABLE group_work_shop ADD CONSTRAINT group_work_shop__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_work_shop ADD CONSTRAINT group_work_shop__work_shop_id__work_shop_id_fk FOREIGN KEY (work_shop_id) REFERENCES work_shop (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE work_shop_group DROP CONSTRAINT IF EXISTS work_shop_group__work_shop_id__work_shop__id_fk');
        $this->addSql('ALTER TABLE work_shop_group DROP CONSTRAINT IF EXISTS work_shop_group__group_id__group__id_fk');
        $this->addSql('DROP TABLE IF EXISTS work_shop_group');
    }
}
