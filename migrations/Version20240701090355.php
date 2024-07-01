<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701090355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE xml_data (entity_id INT NOT NULL, category_name VARCHAR(255) NOT NULL, sku VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, shortdesc LONGTEXT DEFAULT NULL, price VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, rating VARCHAR(255) NOT NULL, caffeine_type VARCHAR(255) NOT NULL, count VARCHAR(255) NOT NULL, flavored VARCHAR(255) NOT NULL, seasonal VARCHAR(255) NOT NULL, instock VARCHAR(255) NOT NULL, facebook VARCHAR(255) NOT NULL, is_cup VARCHAR(255) NOT NULL, PRIMARY KEY(entity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE xml_data');
    }
}
