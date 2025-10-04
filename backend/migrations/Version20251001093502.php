<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251001093502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, price DOUBLE PRECISION NOT NULL, status SMALLINT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_vacancy (id INT AUTO_INCREMENT NOT NULL, reservation_id INT NOT NULL, vacancy_id INT NOT NULL, INDEX IDX_CEA1D738B83297E7 (reservation_id), INDEX IDX_CEA1D738433B78C4 (vacancy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacancies (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, price DOUBLE PRECISION NOT NULL, total_count INT NOT NULL, available_count INT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(255) DEFAULT NULL, location VARCHAR(50) DEFAULT NULL, owner VARCHAR(50) NOT NULL, INDEX idx_vacancy_date (date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_vacancy ADD CONSTRAINT FK_CEA1D738B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)');
        $this->addSql('ALTER TABLE reservation_vacancy ADD CONSTRAINT FK_CEA1D738433B78C4 FOREIGN KEY (vacancy_id) REFERENCES vacancies (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_vacancy DROP FOREIGN KEY FK_CEA1D738B83297E7');
        $this->addSql('ALTER TABLE reservation_vacancy DROP FOREIGN KEY FK_CEA1D738433B78C4');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_vacancy');
        $this->addSql('DROP TABLE vacancies');
    }
}
