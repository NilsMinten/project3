<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821142940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_type ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE masterclass ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tournament ADD name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_type DROP name');
        $this->addSql('ALTER TABLE masterclass DROP name');
        $this->addSql('ALTER TABLE tournament DROP name');
    }
}
