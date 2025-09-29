<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929120253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, name TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE truc ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE truc ADD CONSTRAINT FK_149FE9B812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_149FE9B812469DE2 ON truc (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE truc DROP CONSTRAINT FK_149FE9B812469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_149FE9B812469DE2');
        $this->addSql('ALTER TABLE truc DROP category_id');
    }
}
