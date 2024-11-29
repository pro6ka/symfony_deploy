<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240925034023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fixation_group DROP CONSTRAINT fixation_group__fixation_id__group__id_fk');
        $this->addSql('ALTER TABLE fixation_group DROP CONSTRAINT fixation_group__group_id__group__id_fk');
        $this->addSql('DROP TABLE fixation_group');
        $this->addSql('ALTER TABLE "group" ADD fixations_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE "group" ADD CONSTRAINT FK_6DC044C530BB061E FOREIGN KEY (fixations_id) REFERENCES fixation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6DC044C530BB061E ON "group" (fixations_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fixation_group (fixation_id BIGINT NOT NULL, group_id BIGINT NOT NULL, PRIMARY KEY(fixation_id, group_id))');
        $this->addSql('CREATE INDEX idx_14c44d54fe54d947 ON fixation_group (group_id)');
        $this->addSql('CREATE INDEX idx_14c44d54c769d5e1 ON fixation_group (fixation_id)');
        $this->addSql('ALTER TABLE fixation_group ADD CONSTRAINT fixation_group__fixation_id__group__id_fk FOREIGN KEY (fixation_id) REFERENCES fixation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fixation_group ADD CONSTRAINT fixation_group__group_id__group__id_fk FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "group" DROP CONSTRAINT FK_6DC044C530BB061E');
        $this->addSql('DROP INDEX IDX_6DC044C530BB061E');
        $this->addSql('ALTER TABLE "group" DROP fixations_id');
    }
}
