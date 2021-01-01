<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191021113912 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE negocio CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tiquet DROP FOREIGN KEY FK_7B08BCCD7D879E4F');
        $this->addSql('ALTER TABLE tiquet CHANGE usuario_id usuario_id INT DEFAULT NULL, CHANGE negocio_id negocio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tiquet ADD CONSTRAINT FK_7B08BCCD7D879E4F FOREIGN KEY (negocio_id) REFERENCES negocio (id)');
        $this->addSql('ALTER TABLE usuario CHANGE role role VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE negocio CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tiquet DROP FOREIGN KEY FK_7B08BCCD7D879E4F');
        $this->addSql('ALTER TABLE tiquet CHANGE usuario_id usuario_id INT DEFAULT NULL, CHANGE negocio_id negocio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tiquet ADD CONSTRAINT FK_7B08BCCD7D879E4F FOREIGN KEY (negocio_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario CHANGE role role VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
