<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240920035312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE work_shop_user DROP CONSTRAINT IF EXISTS work_shop_user__work_showp_id__work_shop__id_fk');
        $this->addSql('ALTER TABLE work_shop_user DROP CONSTRAINT IF EXISTS work_shop_user__user_id__user__id_fk');
        $this->addSql('DROP TABLE IF EXISTS work_shop_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS work_shop_user (work_shop_id BIGINT NOT NULL, user_id BIGINT NOT NULL, PRIMARY KEY(work_shop_id, user_id))');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_2e699867a76ed395 ON work_shop_user (user_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_2e69986798dd7cff ON work_shop_user (work_shop_id)');
        $this->addSql('ALTER TABLE work_shop_user ADD CONSTRAINT work_shop_user__work_showp_id__work_shop__id_fk FOREIGN KEY (work_shop_id) REFERENCES work_shop (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE work_shop_user ADD CONSTRAINT work_shop_user__user_id__user__id_fk FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
