<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210814132802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE filters_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mpolls_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mpolls_quotas_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quotas_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE filter_types (id INT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE filters (id INT NOT NULL, filter_type_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(4000) NOT NULL, description VARCHAR(4000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX filters__filter_type_id__idx ON filters (filter_type_id)');
        $this->addSql('CREATE TABLE mpolls (id INT NOT NULL, name VARCHAR(50) NOT NULL, mstatus INT NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, ended_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, description VARCHAR(255) DEFAULT NULL, clicks INT DEFAULT NULL, repeatable BOOLEAN DEFAULT NULL, lenght INT NOT NULL, surv_limit INT DEFAULT NULL, prescreener VARCHAR(2048) DEFAULT NULL, link VARCHAR(1024) NOT NULL, filename VARCHAR(50) DEFAULT NULL, in_cabinet BOOLEAN DEFAULT NULL, cab_link VARCHAR(255) DEFAULT NULL, complites INT DEFAULT NULL, overquotas INT DEFAULT NULL, screenouts INT DEFAULT NULL, check_geo BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN mpolls.started_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN mpolls.ended_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE mpolls_quotas (id INT NOT NULL, mpoll_id INT DEFAULT NULL, quota_id INT NOT NULL, sent INT DEFAULT NULL, send_posible INT DEFAULT NULL, sending INT DEFAULT NULL, send_order VARCHAR(10) DEFAULT NULL, clicks INT DEFAULT NULL, prescreener VARCHAR(2048) DEFAULT NULL, overquota INT DEFAULT NULL, screenout INT DEFAULT NULL, completes INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX mpolls_quotas__mpoll_id__idx ON mpolls_quotas (mpoll_id)');
        $this->addSql('CREATE INDEX mpolls_quotas__quota_id__idx ON mpolls_quotas (quota_id)');
        $this->addSql('CREATE TABLE quotas (id INT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quota_filter (quota_id INT NOT NULL, filter_id INT NOT NULL, PRIMARY KEY(quota_id, filter_id))');
        $this->addSql('CREATE INDEX IDX_C136FFA454E2C62F ON quota_filter (quota_id)');
        $this->addSql('CREATE INDEX IDX_C136FFA4D395B25E ON quota_filter (filter_id)');
        $this->addSql('ALTER TABLE quota_filter ADD CONSTRAINT FK_C136FFA454E2C62F FOREIGN KEY (quota_id) REFERENCES quotas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quota_filter ADD CONSTRAINT FK_C136FFA4D395B25E FOREIGN KEY (filter_id) REFERENCES filters (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quota_filter DROP CONSTRAINT FK_C136FFA4D395B25E');
        $this->addSql('ALTER TABLE quota_filter DROP CONSTRAINT FK_C136FFA454E2C62F');
        $this->addSql('DROP SEQUENCE filters_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mpolls_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mpolls_quotas_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quotas_id_seq CASCADE');
        $this->addSql('DROP TABLE filter_types');
        $this->addSql('DROP TABLE filters');
        $this->addSql('DROP TABLE mpolls');
        $this->addSql('DROP TABLE mpolls_quotas');
        $this->addSql('DROP TABLE quotas');
        $this->addSql('DROP TABLE quota_filter');
    }
}
