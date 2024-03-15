<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240315112635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE machine (
                        id INT AUTO_INCREMENT NOT NULL,
                        name VARCHAR(255) NOT NULL, 
                        memory INT NOT NULL, 
                        processors INT NOT NULL, 
                        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE process (
                        id INT AUTO_INCREMENT NOT NULL, 
                        machine_id INT DEFAULT NULL, 
                        name VARCHAR(255) NOT NULL, 
                        required_memory INT NOT NULL, 
                        required_processors INT NOT NULL, 
                        INDEX IDX_861D1896F6B75B26 (machine_id), 
                        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE process DROP FOREIGN KEY FK_861D1896F6B75B26');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP TABLE process');
    }
}
