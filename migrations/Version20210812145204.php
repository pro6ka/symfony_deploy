<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210812145204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quotahasfilter DROP CONSTRAINT fk_8b5d11f954e2c62f');
        $this->addSql('ALTER TABLE quota_detail DROP CONSTRAINT fk_90f4df2a54e2c62f');
        $this->addSql('DROP SEQUENCE quota_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quota_detail_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE mpoll_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quotas_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mpoll_detail (id INT NOT NULL, mpolls_id INT NOT NULL, quotas_id INT NOT NULL, sent INT DEFAULT NULL, send_posible INT DEFAULT NULL, sending INT DEFAULT NULL, send_order VARCHAR(10) DEFAULT NULL, clicks INT DEFAULT NULL, prescreener VARCHAR(2048) DEFAULT NULL, overquota INT DEFAULT NULL, screenout INT DEFAULT NULL, completes INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64AC26AD59F599FC ON mpoll_detail (mpolls_id)');
        $this->addSql('CREATE INDEX IDX_64AC26AD4CF462BA ON mpoll_detail (quotas_id)');
        $this->addSql('CREATE TABLE quotas (id INT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quota_filter (quota_id INT NOT NULL, filter_id INT NOT NULL, PRIMARY KEY(quota_id, filter_id))');
        $this->addSql('CREATE INDEX IDX_C136FFA454E2C62F ON quota_filter (quota_id)');
        $this->addSql('CREATE INDEX IDX_C136FFA4D395B25E ON quota_filter (filter_id)');
        $this->addSql('ALTER TABLE mpoll_detail ADD CONSTRAINT FK_64AC26AD59F599FC FOREIGN KEY (mpolls_id) REFERENCES mpolls (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mpoll_detail ADD CONSTRAINT FK_64AC26AD4CF462BA FOREIGN KEY (quotas_id) REFERENCES quotas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quota_filter ADD CONSTRAINT FK_C136FFA454E2C62F FOREIGN KEY (quota_id) REFERENCES quotas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quota_filter ADD CONSTRAINT FK_C136FFA4D395B25E FOREIGN KEY (filter_id) REFERENCES filter (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE quotahasfilter');
        $this->addSql('DROP TABLE quota');
        $this->addSql('DROP TABLE quota_detail');
        $this->addSql('ALTER TABLE mpolls DROP country');
        $this->addSql('ALTER TABLE mpolls DROP mail');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mpoll_detail DROP CONSTRAINT FK_64AC26AD4CF462BA');
        $this->addSql('ALTER TABLE quota_filter DROP CONSTRAINT FK_C136FFA454E2C62F');
        $this->addSql('DROP SEQUENCE mpoll_detail_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE quotas_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE quota_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE quota_detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE quotahasfilter (filter_id INT NOT NULL, quota_id INT NOT NULL, PRIMARY KEY(filter_id, quota_id))');
        $this->addSql('CREATE INDEX idx_8b5d11f9d395b25e ON quotahasfilter (filter_id)');
        $this->addSql('CREATE INDEX idx_8b5d11f954e2c62f ON quotahasfilter (quota_id)');
        $this->addSql('CREATE TABLE quota (id INT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quota_detail (id INT NOT NULL, mpoll_id INT DEFAULT NULL, quota_id INT DEFAULT NULL, completes INT DEFAULT NULL, sent INT DEFAULT NULL, send_posible INT DEFAULT NULL, sending INT DEFAULT NULL, send_order VARCHAR(10) NOT NULL, prescreener VARCHAR(2048) DEFAULT NULL, overquota INT DEFAULT NULL, screenout INT DEFAULT NULL, complete INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_90f4df2a54e2c62f ON quota_detail (quota_id)');
        $this->addSql('CREATE INDEX idx_90f4df2a8f34c972 ON quota_detail (mpoll_id)');
        $this->addSql('ALTER TABLE quotahasfilter ADD CONSTRAINT fk_8b5d11f9d395b25e FOREIGN KEY (filter_id) REFERENCES filter (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quotahasfilter ADD CONSTRAINT fk_8b5d11f954e2c62f FOREIGN KEY (quota_id) REFERENCES quota (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quota_detail ADD CONSTRAINT fk_90f4df2a8f34c972 FOREIGN KEY (mpoll_id) REFERENCES mpolls (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quota_detail ADD CONSTRAINT fk_90f4df2a54e2c62f FOREIGN KEY (quota_id) REFERENCES quota (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE mpoll_detail');
        $this->addSql('DROP TABLE quotas');
        $this->addSql('DROP TABLE quota_filter');
        $this->addSql('ALTER TABLE mpolls ADD country INT NOT NULL');
        $this->addSql('ALTER TABLE mpolls ADD mail VARCHAR(255) DEFAULT NULL');
    }
}
