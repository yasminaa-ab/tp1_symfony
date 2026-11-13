<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261113213049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD auteuruser_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66778E4164 FOREIGN KEY (auteuruser_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66778E4164 ON article (auteuruser_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66778E4164');
        $this->addSql('DROP INDEX IDX_23A0E66778E4164 ON article');
        $this->addSql('ALTER TABLE article DROP auteuruser_id');
    }
}
