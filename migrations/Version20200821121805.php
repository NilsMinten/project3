<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821121805 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_type (id INT AUTO_INCREMENT NOT NULL, ratings_id INT DEFAULT NULL, masterclasses_id INT DEFAULT NULL, tournaments_id INT DEFAULT NULL, rules LONGTEXT NOT NULL, min_rating_for_masterclass INT NOT NULL, INDEX IDX_67CB3B05957CE84F (ratings_id), INDEX IDX_67CB3B05A0215974 (masterclasses_id), INDEX IDX_67CB3B05D92C1B5D (tournaments_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE masterclass (id INT AUTO_INCREMENT NOT NULL, minimum_rating INT NOT NULL, maximum_members INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating_points (id INT AUTO_INCREMENT NOT NULL, rating INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament (id INT AUTO_INCREMENT NOT NULL, price_money INT NOT NULL, maximum_members INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_masterclass (user_id INT NOT NULL, masterclass_id INT NOT NULL, INDEX IDX_32C08D78A76ED395 (user_id), INDEX IDX_32C08D78426F0705 (masterclass_id), PRIMARY KEY(user_id, masterclass_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_tournament (user_id INT NOT NULL, tournament_id INT NOT NULL, INDEX IDX_1A387E35A76ED395 (user_id), INDEX IDX_1A387E3533D1A3E7 (tournament_id), PRIMARY KEY(user_id, tournament_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_type ADD CONSTRAINT FK_67CB3B05957CE84F FOREIGN KEY (ratings_id) REFERENCES rating_points (id)');
        $this->addSql('ALTER TABLE game_type ADD CONSTRAINT FK_67CB3B05A0215974 FOREIGN KEY (masterclasses_id) REFERENCES masterclass (id)');
        $this->addSql('ALTER TABLE game_type ADD CONSTRAINT FK_67CB3B05D92C1B5D FOREIGN KEY (tournaments_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE user_masterclass ADD CONSTRAINT FK_32C08D78A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_masterclass ADD CONSTRAINT FK_32C08D78426F0705 FOREIGN KEY (masterclass_id) REFERENCES masterclass (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tournament ADD CONSTRAINT FK_1A387E35A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tournament ADD CONSTRAINT FK_1A387E3533D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD rating_id INT DEFAULT NULL, DROP rating');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A32EFC6 FOREIGN KEY (rating_id) REFERENCES rating_points (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A32EFC6 ON user (rating_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_type DROP FOREIGN KEY FK_67CB3B05A0215974');
        $this->addSql('ALTER TABLE user_masterclass DROP FOREIGN KEY FK_32C08D78426F0705');
        $this->addSql('ALTER TABLE game_type DROP FOREIGN KEY FK_67CB3B05957CE84F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A32EFC6');
        $this->addSql('ALTER TABLE game_type DROP FOREIGN KEY FK_67CB3B05D92C1B5D');
        $this->addSql('ALTER TABLE user_tournament DROP FOREIGN KEY FK_1A387E3533D1A3E7');
        $this->addSql('DROP TABLE game_type');
        $this->addSql('DROP TABLE masterclass');
        $this->addSql('DROP TABLE rating_points');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE user_masterclass');
        $this->addSql('DROP TABLE user_tournament');
        $this->addSql('DROP INDEX IDX_8D93D649A32EFC6 ON user');
        $this->addSql('ALTER TABLE user ADD rating INT NOT NULL, DROP rating_id');
    }
}
