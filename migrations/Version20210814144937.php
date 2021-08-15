<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210814144937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE mpolls_quotas ALTER quota_id DROP NOT NULL');
        $this->addSql('ALTER TABLE mpolls_quotas ADD CONSTRAINT mpolls_quotas__quota_id__fk FOREIGN KEY (quota_id) REFERENCES quotas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mpolls_quotas ADD CONSTRAINT mpolls_quotas__mpoll_id__fk FOREIGN KEY (mpoll_id) REFERENCES mpolls (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql(
            'ALTER TABLE filters ADD CONSTRAINT filter_types__filter_type_id__fk FOREIGN KEY (filter_type_id) REFERENCES filter_types (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mpolls_quotas DROP CONSTRAINT mpolls_quotas__quota_id__fk');
//        $this->addSql('ALTER TABLE mpolls_quotas ALTER quota_id SET NOT NULL');
        $this->addSql('ALTER TABLE mpolls_quotas DROP CONSTRAINT mpolls_quotas__mpoll_id__fk');
        $this->addSql('ALTER TABLE filters DROP CONSTRAINT filter_types__filter_type_id__fk');
    }
}
