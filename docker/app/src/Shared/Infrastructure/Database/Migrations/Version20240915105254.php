<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240915105254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders_order (id VARCHAR(26) NOT NULL, user_id VARCHAR(26) NOT NULL, sum DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE orders_order_modifications (id VARCHAR(26) NOT NULL, order_id VARCHAR(26) DEFAULT NULL, status VARCHAR(26) NOT NULL, changed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BC2407C98D9F6D38 ON orders_order_modifications (order_id)');
        $this->addSql('COMMENT ON COLUMN orders_order_modifications.changed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE orders_order_modifications ADD CONSTRAINT FK_BC2407C98D9F6D38 FOREIGN KEY (order_id) REFERENCES orders_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders_order_modifications DROP CONSTRAINT FK_BC2407C98D9F6D38');
        $this->addSql('DROP TABLE orders_order');
        $this->addSql('DROP TABLE orders_order_modifications');
    }
}
