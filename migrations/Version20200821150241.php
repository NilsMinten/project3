<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821150241 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournament ADD game_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D9508EF3BC FOREIGN KEY (game_type_id) REFERENCES game_type (id)');
        $this->addSql('CREATE INDEX IDX_BD5FB8D9508EF3BC ON tournament (game_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournament DROP FOREIGN KEY FK_BD5FB8D9508EF3BC');
        $this->addSql('DROP INDEX IDX_BD5FB8D9508EF3BC ON tournament');
        $this->addSql('ALTER TABLE tournament DROP game_type_id');
    }
}
