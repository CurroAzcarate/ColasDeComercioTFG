<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200815123935 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE negocio CHANGE usuario_id usuario_id INT DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE negocio ADD CONSTRAINT FK_7528E379DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_7528E379DB38439E ON negocio (usuario_id)');
        $this->addSql('ALTER TABLE tiquet CHANGE usuario_id usuario_id INT DEFAULT NULL, CHANGE negocio_id negocio_id INT DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE tiquet ADD CONSTRAINT FK_7B08BCCDDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE tiquet ADD CONSTRAINT FK_7B08BCCD7D879E4F FOREIGN KEY (negocio_id) REFERENCES negocio (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B08BCCD20332D99 ON tiquet (codigo)');
        $this->addSql('CREATE INDEX IDX_7B08BCCDDB38439E ON tiquet (usuario_id)');
        $this->addSql('CREATE INDEX IDX_7B08BCCD7D879E4F ON tiquet (negocio_id)');
        $this->addSql('ALTER TABLE usuario CHANGE role role VARCHAR(50) DEFAULT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DE7927C74 ON usuario (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE negocio MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE negocio DROP FOREIGN KEY FK_7528E379DB38439E');
        $this->addSql('DROP INDEX IDX_7528E379DB38439E ON negocio');
        $this->addSql('ALTER TABLE negocio DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE negocio CHANGE usuario_id usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tiquet MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE tiquet DROP FOREIGN KEY FK_7B08BCCDDB38439E');
        $this->addSql('ALTER TABLE tiquet DROP FOREIGN KEY FK_7B08BCCD7D879E4F');
        $this->addSql('DROP INDEX UNIQ_7B08BCCD20332D99 ON tiquet');
        $this->addSql('DROP INDEX IDX_7B08BCCDDB38439E ON tiquet');
        $this->addSql('DROP INDEX IDX_7B08BCCD7D879E4F ON tiquet');
        $this->addSql('ALTER TABLE tiquet DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE tiquet CHANGE usuario_id usuario_id INT DEFAULT NULL, CHANGE negocio_id negocio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_2265B05DE7927C74 ON usuario');
        $this->addSql('ALTER TABLE usuario DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE usuario CHANGE role role VARCHAR(50) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
