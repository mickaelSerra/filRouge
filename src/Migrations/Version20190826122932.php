<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190826122932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personnages ADD jeux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personnages ADD CONSTRAINT FK_286738A6EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
        $this->addSql('CREATE INDEX IDX_286738A6EC2AA9D2 ON personnages (jeux_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE personnages DROP FOREIGN KEY FK_286738A6EC2AA9D2');
        $this->addSql('DROP INDEX IDX_286738A6EC2AA9D2 ON personnages');
        $this->addSql('ALTER TABLE personnages DROP jeux_id');
    }
}
