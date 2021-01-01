<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021113609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE negocio (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, nombre VARCHAR(100) NOT NULL, descripcion VARCHAR(300) NOT NULL, create_at DATETIME NOT NULL, INDEX IDX_7528E379DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tiquet (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, negocio_id INT DEFAULT NULL, codigo VARCHAR(100) NOT NULL, estado VARCHAR(100) NOT NULL, create_at DATETIME NOT NULL, INDEX IDX_7B08BCCDDB38439E (usuario_id), INDEX IDX_7B08BCCD7D879E4F (negocio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, role VARCHAR(50) DEFAULT NULL, name VARCHAR(100) NOT NULL, surname VARCHAR(200) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, create_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE negocio ADD CONSTRAINT FK_7528E379DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE tiquet ADD CONSTRAINT FK_7B08BCCDDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE tiquet ADD CONSTRAINT FK_7B08BCCD7D879E4F FOREIGN KEY (negocio_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE negocio DROP FOREIGN KEY FK_7528E379DB38439E');
        $this->addSql('ALTER TABLE tiquet DROP FOREIGN KEY FK_7B08BCCDDB38439E');
        $this->addSql('ALTER TABLE tiquet DROP FOREIGN KEY FK_7B08BCCD7D879E4F');
        $this->addSql('DROP TABLE negocio');
        $this->addSql('DROP TABLE tiquet');
        $this->addSql('DROP TABLE usuario');
    }
}
