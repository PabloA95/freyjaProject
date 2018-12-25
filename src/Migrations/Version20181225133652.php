<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181225133652 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producto ADD marca INT DEFAULT NULL, ADD descripcion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB061570A0113 FOREIGN KEY (marca) REFERENCES marca (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615A02A2F00 FOREIGN KEY (descripcion) REFERENCES descripcion (id)');
        $this->addSql('CREATE INDEX IDX_A7BB061570A0113 ON producto (marca)');
        $this->addSql('CREATE INDEX IDX_A7BB0615A02A2F00 ON producto (descripcion)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB061570A0113');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615A02A2F00');
        $this->addSql('DROP INDEX IDX_A7BB061570A0113 ON producto');
        $this->addSql('DROP INDEX IDX_A7BB0615A02A2F00 ON producto');
        $this->addSql('ALTER TABLE producto DROP marca, DROP descripcion');
    }
}
