<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104110620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE audit__shipping_orders (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, status_id INT DEFAULT NULL, status_name VARCHAR(255) DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, shipping_tracking_number VARCHAR(255) DEFAULT NULL, shipping_company VARCHAR(255) DEFAULT NULL, shipping_details LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, action LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit__shipping_orders_issues (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, issue_id INT DEFAULT NULL, issue_name VARCHAR(255) DEFAULT NULL, issue_details LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, action LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE audit__shipping_orders_items (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, box_id INT DEFAULT NULL, product_id INT DEFAULT NULL, product_name VARCHAR(255) DEFAULT NULL, box_name VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, action LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders__products (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders__shipping_boxes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders__shipping_orders (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, order_id INT NOT NULL, total DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION NOT NULL, shipping_tracking_number VARCHAR(255) DEFAULT NULL, shipping_company VARCHAR(255) DEFAULT NULL, shipping_details LONGTEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX UNIQ_4FB321988D9F6D38 (order_id), INDEX IDX_4FB321986BF700BD (status_id), INDEX order_id_index (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders__shipping_orders_issues (id INT AUTO_INCREMENT NOT NULL, shipping_order_id INT NOT NULL, issue_id INT DEFAULT NULL, details LONGTEXT DEFAULT NULL, INDEX IDX_A7894C6711702397 (shipping_order_id), INDEX IDX_A7894C675E7AA58C (issue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders__shipping_orders_items (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, shipping_order_id INT NOT NULL, shipping_box_id INT DEFAULT NULL, quantity INT DEFAULT 1 NOT NULL, INDEX IDX_12B3BCC24584665A (product_id), INDEX IDX_12B3BCC211702397 (shipping_order_id), INDEX IDX_12B3BCC2F34DBE70 (shipping_box_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders__shipping_orders_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilities__issues (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders__shipping_orders ADD CONSTRAINT FK_4FB321986BF700BD FOREIGN KEY (status_id) REFERENCES orders__shipping_orders_status (id)');
        $this->addSql('ALTER TABLE orders__shipping_orders_issues ADD CONSTRAINT FK_A7894C6711702397 FOREIGN KEY (shipping_order_id) REFERENCES orders__shipping_orders (id)');
        $this->addSql('ALTER TABLE orders__shipping_orders_issues ADD CONSTRAINT FK_A7894C675E7AA58C FOREIGN KEY (issue_id) REFERENCES utilities__issues (id)');
        $this->addSql('ALTER TABLE orders__shipping_orders_items ADD CONSTRAINT FK_12B3BCC24584665A FOREIGN KEY (product_id) REFERENCES orders__products (id)');
        $this->addSql('ALTER TABLE orders__shipping_orders_items ADD CONSTRAINT FK_12B3BCC211702397 FOREIGN KEY (shipping_order_id) REFERENCES orders__shipping_orders (id)');
        $this->addSql('ALTER TABLE orders__shipping_orders_items ADD CONSTRAINT FK_12B3BCC2F34DBE70 FOREIGN KEY (shipping_box_id) REFERENCES orders__shipping_boxes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders__shipping_orders_items DROP FOREIGN KEY FK_12B3BCC24584665A');
        $this->addSql('ALTER TABLE orders__shipping_orders_items DROP FOREIGN KEY FK_12B3BCC2F34DBE70');
        $this->addSql('ALTER TABLE orders__shipping_orders_issues DROP FOREIGN KEY FK_A7894C6711702397');
        $this->addSql('ALTER TABLE orders__shipping_orders_items DROP FOREIGN KEY FK_12B3BCC211702397');
        $this->addSql('ALTER TABLE orders__shipping_orders DROP FOREIGN KEY FK_4FB321986BF700BD');
        $this->addSql('ALTER TABLE orders__shipping_orders_issues DROP FOREIGN KEY FK_A7894C675E7AA58C');
        $this->addSql('DROP TABLE audit__shipping_orders');
        $this->addSql('DROP TABLE audit__shipping_orders_issues');
        $this->addSql('DROP TABLE audit__shipping_orders_items');
        $this->addSql('DROP TABLE orders__products');
        $this->addSql('DROP TABLE orders__shipping_boxes');
        $this->addSql('DROP TABLE orders__shipping_orders');
        $this->addSql('DROP TABLE orders__shipping_orders_issues');
        $this->addSql('DROP TABLE orders__shipping_orders_items');
        $this->addSql('DROP TABLE orders__shipping_orders_status');
        $this->addSql('DROP TABLE utilities__issues');
    }
}
