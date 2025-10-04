<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251001140601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD name VARCHAR(100) NOT NULL, ADD surname VARCHAR(100) NOT NULL, ADD email VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE vacancies DROP name, DROP description, DROP location, DROP owner');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP name, DROP surname, DROP email');
        $this->addSql('ALTER TABLE vacancies ADD name VARCHAR(50) NOT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD location VARCHAR(50) DEFAULT NULL, ADD owner VARCHAR(50) NOT NULL');
    }
}
