<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210628092230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, complement_adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, cp INT NOT NULL, country VARCHAR(255) NOT NULL, tel INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery_adress (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, complement_adress VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, cp INT NOT NULL, country VARCHAR(255) NOT NULL, tel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_product (payment_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_CA030A474C3A3BB (payment_id), INDEX IDX_CA030A474584665A (product_id), PRIMARY KEY(payment_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment_product ADD CONSTRAINT FK_CA030A474C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment_product ADD CONSTRAINT FK_CA030A474584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE participant');
        $this->addSql('ALTER TABLE payment ADD delivery_id INT DEFAULT NULL, ADD client_id INT DEFAULT NULL, ADD ref_commande VARCHAR(255) NOT NULL, ADD adress_client VARCHAR(255) NOT NULL, ADD mode_payment VARCHAR(255) NOT NULL, DROP amount, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D12136921 FOREIGN KEY (delivery_id) REFERENCES delivery_adress (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D12136921 ON payment (delivery_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D19EB6921 ON payment (client_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D19EB6921');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D12136921');
        $this->addSql('ALTER TABLE payment_product DROP FOREIGN KEY FK_CA030A474584665A');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, campaign_id INT NOT NULL, is_anonymous TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE delivery_adress');
        $this->addSql('DROP TABLE payment_product');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP INDEX IDX_6D28840D12136921 ON payment');
        $this->addSql('DROP INDEX IDX_6D28840D19EB6921 ON payment');
        $this->addSql('ALTER TABLE payment ADD amount INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP delivery_id, DROP client_id, DROP ref_commande, DROP adress_client, DROP mode_payment');
    }
}
