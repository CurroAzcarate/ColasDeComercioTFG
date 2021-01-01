<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200815134211 extends AbstractMigration
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
        $this->addSql('ALTER TABLE tiquet CHANGE usuario_id usuario_id INT DEFAULT NULL, CHANGE negocio_id negocio_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B08BCCD20332D99 ON tiquet (codigo)');
        $this->addSql('ALTER TABLE usuario CHANGE role role VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DE7927C74 ON usuario (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE negocio CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_7B08BCCD20332D99 ON tiquet');
        $this->addSql('ALTER TABLE tiquet CHANGE usuario_id usuario_id INT DEFAULT NULL, CHANGE negocio_id negocio_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_2265B05DE7927C74 ON usuario');
        $this->addSql('ALTER TABLE usuario CHANGE role role VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
