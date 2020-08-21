<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821122420 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating_points ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating_points ADD CONSTRAINT FK_848E4A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_848E4A1A76ED395 ON rating_points (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649A32EFC6');
        $this->addSql('DROP INDEX IDX_8D93D649A32EFC6 ON user');
        $this->addSql('ALTER TABLE user DROP rating_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating_points DROP FOREIGN KEY FK_848E4A1A76ED395');
        $this->addSql('DROP INDEX IDX_848E4A1A76ED395 ON rating_points');
        $this->addSql('ALTER TABLE rating_points DROP user_id');
        $this->addSql('ALTER TABLE user ADD rating_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649A32EFC6 FOREIGN KEY (rating_id) REFERENCES rating_points (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649A32EFC6 ON user (rating_id)');
    }
}
