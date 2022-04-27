<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122211605 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'table Product';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(<<<SQL
                        CREATE TABLE product
                        (
                            id           INT                            NOT NULL,
                            category_id  INT                            NOT NULL,
                            name         VARCHAR(255)                   NOT NULL,
                            slug         VARCHAR(255)                   NOT NULL,
                            price        INT                            NOT NULL,
                            sku_number   VARCHAR(255)                   NOT NULL,
                            image_paths  JSONB DEFAULT NULL,
                            description  TEXT         DEFAULT NULL,
                            stock        INT                            NOT NULL,
                            created_at   TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                            updated_at   TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                            PRIMARY KEY (id)
                        );
                     SQL);
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_9474526C604B8382 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_product_name ON product (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_product_slug ON product (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_product_sku_number ON product (sku_number)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('ALTER TABLE product DROP CONSTRAINT FK_9474526C604B8382');
        $this->addSql('DROP TABLE product');
    }
}