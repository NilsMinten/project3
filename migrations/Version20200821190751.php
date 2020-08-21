<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821190751 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
    	$this->addSql('INSERT INTO `user` (`username`, `roles`, `password`, `email`, `first_name`, `last_name`) VALUES ("admin", "[\"ROLE_ADMIN\"]", "$argon2id$v=19$m=65536,t=4,p=1$kWIRlvEGgyemV56YCEioIw$AZkW/d4pCrWY2YkF0Rzq3k+N+xIq7jD9GlHZwH7ZKM8", "examinator@novi.nl", "Examinator", "novi") ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
