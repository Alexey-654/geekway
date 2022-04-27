<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220122211443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'table category';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql(<<<SQL
                        CREATE TABLE category
                        (
                            id         INT                            NOT NULL,
                            name       VARCHAR(255)                   NOT NULL,
                            slug       VARCHAR(255)                   NOT NULL,
                            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                            updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                            PRIMARY KEY (id)
                        );
                     SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP TABLE category');
    }
}