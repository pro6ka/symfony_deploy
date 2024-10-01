<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241001041334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER INDEX user__login_unique RENAME TO UNIQ_8D93D649AA08CB10');
        $this->addSql('ALTER INDEX user__email_unique RENAME TO UNIQ_8D93D649E7927C74');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER INDEX uniq_8d93d649aa08cb10 RENAME TO user__login_unique');
        $this->addSql('ALTER INDEX uniq_8d93d649e7927c74 RENAME TO user__email_unique');
    }
}
