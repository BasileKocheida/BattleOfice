<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629101837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE payment_product');
        $this->addSql('ALTER TABLE payment ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D4584665A ON payment (product_id)');
        $this->addSql('ALTER TABLE product CHANGE text_promo text_promo VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment_product (payment_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_CA030A474584665A (product_id), INDEX IDX_CA030A474C3A3BB (payment_id), PRIMARY KEY(payment_id, product_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE payment_product ADD CONSTRAINT FK_CA030A474584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment_product ADD CONSTRAINT FK_CA030A474C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D4584665A');
        $this->addSql('DROP INDEX IDX_6D28840D4584665A ON payment');
        $this->addSql('ALTER TABLE payment DROP product_id');
        $this->addSql('ALTER TABLE product CHANGE text_promo text_promo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
