<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220023312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pedido_detalle (id INT AUTO_INCREMENT NOT NULL, pedido_id INT NOT NULL, descripcion VARCHAR(100) NOT NULL, peso DOUBLE PRECISION NOT NULL, INDEX IDX_E240F45E4854653A (pedido_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pedido_detalle ADD CONSTRAINT FK_E240F45E4854653A FOREIGN KEY (pedido_id) REFERENCES pedido (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido_detalle DROP FOREIGN KEY FK_E240F45E4854653A');
        $this->addSql('DROP TABLE pedido_detalle');
    }
}
