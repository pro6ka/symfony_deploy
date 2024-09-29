<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240927033033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "group" DROP CONSTRAINT IF EXISTS fk_6dc044c530bb061e');
        $this->addSql('DROP INDEX IF EXISTS idx_6dc044c530bb061e');
        $this->addSql('ALTER TABLE "group" DROP fixations_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "group" ADD IF NOT EXISTS fixations_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE "group" ADD CONSTRAINT group__fixation_id__fixation__id FOREIGN KEY (fixations_id) REFERENCES fixation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IF NOT EXISTS idx_6dc044c530bb061e ON "group" (fixations_id)');
    }
}
