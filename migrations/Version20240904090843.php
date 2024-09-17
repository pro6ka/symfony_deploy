<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904090843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE IF NOT EXISTS group_user (group_id BIGINT NOT NULL, user_id BIGINT NOT NULL, PRIMARY KEY(group_id, user_id))');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_A4C98D39FE54D947 ON group_user (group_id)');
        $this->addSql('CREATE INDEX IF NOT EXISTS IDX_A4C98D39A76ED395 ON group_user (user_id)');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT group_user__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_user ADD CONSTRAINT group_user__user_id__user__id_fk FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_user DROP CONSTRAINT IF EXISTS FK_A4C98D39FE54D947');
        $this->addSql('ALTER TABLE group_user DROP CONSTRAINT IF EXISTS FK_A4C98D39A76ED395');
        $this->addSql('DROP TABLE IF EXISTS group_user');
    }
}
