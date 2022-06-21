<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220617102242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD prix INT NOT NULL, ADD cover VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, CHANGE lastname lastname VARCHAR(50) DEFAULT NULL, CHANGE firstname firstname VARCHAR(50) DEFAULT NULL, CHANGE postcode postcode VARCHAR(5) DEFAULT NULL, CHANGE phonenumber phonenumber VARCHAR(10) DEFAULT NULL, CHANGE city city VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP prix, DROP cover');
        $this->addSql('ALTER TABLE user DROP is_verified, CHANGE lastname lastname VARCHAR(50) NOT NULL, CHANGE firstname firstname VARCHAR(120) NOT NULL, CHANGE postcode postcode VARCHAR(5) NOT NULL, CHANGE phonenumber phonenumber VARCHAR(10) NOT NULL, CHANGE city city VARCHAR(100) NOT NULL');
    }
}
