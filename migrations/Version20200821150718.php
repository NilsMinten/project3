<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821150718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_type DROP FOREIGN KEY FK_67CB3B05957CE84F');
        $this->addSql('ALTER TABLE game_type DROP FOREIGN KEY FK_67CB3B05A0215974');
        $this->addSql('ALTER TABLE game_type DROP FOREIGN KEY FK_67CB3B05D92C1B5D');
        $this->addSql('DROP INDEX IDX_67CB3B05957CE84F ON game_type');
        $this->addSql('DROP INDEX IDX_67CB3B05D92C1B5D ON game_type');
        $this->addSql('DROP INDEX IDX_67CB3B05A0215974 ON game_type');
        $this->addSql('ALTER TABLE game_type DROP ratings_id, DROP masterclasses_id, DROP tournaments_id');
        $this->addSql('ALTER TABLE masterclass ADD game_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE masterclass ADD CONSTRAINT FK_9BDB44ED508EF3BC FOREIGN KEY (game_type_id) REFERENCES game_type (id)');
        $this->addSql('CREATE INDEX IDX_9BDB44ED508EF3BC ON masterclass (game_type_id)');
        $this->addSql('ALTER TABLE rating_points ADD game_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating_points ADD CONSTRAINT FK_848E4A1508EF3BC FOREIGN KEY (game_type_id) REFERENCES game_type (id)');
        $this->addSql('CREATE INDEX IDX_848E4A1508EF3BC ON rating_points (game_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_type ADD ratings_id INT DEFAULT NULL, ADD masterclasses_id INT DEFAULT NULL, ADD tournaments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game_type ADD CONSTRAINT FK_67CB3B05957CE84F FOREIGN KEY (ratings_id) REFERENCES rating_points (id)');
        $this->addSql('ALTER TABLE game_type ADD CONSTRAINT FK_67CB3B05A0215974 FOREIGN KEY (masterclasses_id) REFERENCES masterclass (id)');
        $this->addSql('ALTER TABLE game_type ADD CONSTRAINT FK_67CB3B05D92C1B5D FOREIGN KEY (tournaments_id) REFERENCES tournament (id)');
        $this->addSql('CREATE INDEX IDX_67CB3B05957CE84F ON game_type (ratings_id)');
        $this->addSql('CREATE INDEX IDX_67CB3B05D92C1B5D ON game_type (tournaments_id)');
        $this->addSql('CREATE INDEX IDX_67CB3B05A0215974 ON game_type (masterclasses_id)');
        $this->addSql('ALTER TABLE masterclass DROP FOREIGN KEY FK_9BDB44ED508EF3BC');
        $this->addSql('DROP INDEX IDX_9BDB44ED508EF3BC ON masterclass');
        $this->addSql('ALTER TABLE masterclass DROP game_type_id');
        $this->addSql('ALTER TABLE rating_points DROP FOREIGN KEY FK_848E4A1508EF3BC');
        $this->addSql('DROP INDEX IDX_848E4A1508EF3BC ON rating_points');
        $this->addSql('ALTER TABLE rating_points DROP game_type_id');
    }
}
