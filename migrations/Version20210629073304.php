<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629073304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD delivery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045512136921 FOREIGN KEY (delivery_id) REFERENCES delivery_adress (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C744045512136921 ON client (delivery_id)');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D12136921');
        $this->addSql('DROP INDEX IDX_6D28840D12136921 ON payment');
        $this->addSql('ALTER TABLE payment DROP delivery_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045512136921');
        $this->addSql('DROP INDEX UNIQ_C744045512136921 ON client');
        $this->addSql('ALTER TABLE client DROP delivery_id');
        $this->addSql('ALTER TABLE payment ADD delivery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D12136921 FOREIGN KEY (delivery_id) REFERENCES delivery_adress (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D12136921 ON payment (delivery_id)');
    }
}
