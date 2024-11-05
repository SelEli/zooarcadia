<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241105135916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks ADD animal_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tasks ADD CONSTRAINT FK_505865978E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id)');
        $this->addSql('CREATE INDEX IDX_505865978E962C16 ON tasks (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tasks DROP FOREIGN KEY FK_505865978E962C16');
        $this->addSql('DROP INDEX IDX_505865978E962C16 ON tasks');
        $this->addSql('ALTER TABLE tasks DROP animal_id, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL');
    }
}
