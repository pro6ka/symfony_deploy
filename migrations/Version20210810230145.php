<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210810230145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE filter_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE mpolls_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quota_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quota_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE filter (id INT NOT NULL, filter_type_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, value VARCHAR(4000) NOT NULL, description VARCHAR(4000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7FC45F1D72DCFBF6 ON filter (filter_type_id)');
        $this->addSql('CREATE TABLE QuotaHasFilter (filter_id INT NOT NULL, quota_id INT NOT NULL, PRIMARY KEY(filter_id, quota_id))');
        $this->addSql('CREATE INDEX IDX_8B5D11F9D395B25E ON QuotaHasFilter (filter_id)');
        $this->addSql('CREATE INDEX IDX_8B5D11F954E2C62F ON QuotaHasFilter (quota_id)');
        $this->addSql('CREATE TABLE filter_type (id INT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE mpolls (id INT NOT NULL, name VARCHAR(50) NOT NULL, mstatus VARCHAR(255) NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, ended_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, price NUMERIC(10, 2) NOT NULL, description VARCHAR(255) DEFAULT NULL, clicks INT DEFAULT NULL, repeatable BOOLEAN DEFAULT NULL, country INT NOT NULL, lenght VARCHAR(10) NOT NULL, surv_limit INT DEFAULT NULL, prescreener VARCHAR(2048) DEFAULT NULL, link VARCHAR(1024) NOT NULL, filename VARCHAR(50) DEFAULT NULL, in_cabinet BOOLEAN DEFAULT NULL, cab_link VARCHAR(255) DEFAULT NULL, complites INT DEFAULT NULL, overquotas INT DEFAULT NULL, screenouts INT DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, check_geo BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN mpolls.started_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN mpolls.ended_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE quota (id INT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quota_detail (id INT NOT NULL, mpoll_id INT DEFAULT NULL, quota_id INT DEFAULT NULL, completes INT DEFAULT NULL, sent INT DEFAULT NULL, send_posible INT DEFAULT NULL, sending INT DEFAULT NULL, send_order VARCHAR(10) NOT NULL, prescreener VARCHAR(2048) DEFAULT NULL, overquota INT DEFAULT NULL, screenout INT DEFAULT NULL, complete INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_90F4DF2A8F34C972 ON quota_detail (mpoll_id)');
        $this->addSql('CREATE INDEX IDX_90F4DF2A54E2C62F ON quota_detail (quota_id)');
        $this->addSql('ALTER TABLE filter ADD CONSTRAINT FK_7FC45F1D72DCFBF6 FOREIGN KEY (filter_type_id) REFERENCES filter_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE QuotaHasFilter ADD CONSTRAINT FK_8B5D11F9D395B25E FOREIGN KEY (filter_id) REFERENCES filter (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE QuotaHasFilter ADD CONSTRAINT FK_8B5D11F954E2C62F FOREIGN KEY (quota_id) REFERENCES quota (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quota_detail ADD CONSTRAINT FK_90F4DF2A8F34C972 FOREIGN KEY (mpoll_id) REFERENCES mpolls (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quota_detail ADD CONSTRAINT FK_90F4DF2A54E2C62F FOREIGN KEY (quota_id) REFERENCES quota (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE QuotaHasFilter DROP CONSTRAINT FK_8B5D11F9D395B25E');
        $this->addSql('ALTER TABLE filter DROP CONSTRAINT FK_7FC45F1D72DCFBF6');
        $this->addSql('ALTER TABLE quota_detail DROP CONSTRAINT FK_90F4DF2A8F34C972');
        $this->addSql('ALTER TABLE QuotaHasFilter DROP CONSTRAINT FK_8B5D11F954E2C62F');
        $this->addSql('ALTER TABLE quota_detail DROP CONSTRAINT FK_90F4DF2A54E2C62F');
        $this->addSql('DROP SEQUENCE filter_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE mpolls_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quota_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quota_detail_id_seq CASCADE');
        $this->addSql('DROP TABLE filter');
        $this->addSql('DROP TABLE QuotaHasFilter');
        $this->addSql('DROP TABLE filter_type');
        $this->addSql('DROP TABLE mpolls');
        $this->addSql('DROP TABLE quota');
        $this->addSql('DROP TABLE quota_detail');
    }
}
