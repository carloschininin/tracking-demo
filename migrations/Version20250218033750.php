<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218033750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pedido (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, empleado_id INT NOT NULL, fecha_registro DATE NOT NULL, fecha_envio DATE DEFAULT NULL, INDEX IDX_C4EC16CEDE734E51 (cliente_id), INDEX IDX_C4EC16CE952BE730 (empleado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE952BE730 FOREIGN KEY (empleado_id) REFERENCES empleado (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CEDE734E51');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE952BE730');
        $this->addSql('DROP TABLE pedido');
    }
}
