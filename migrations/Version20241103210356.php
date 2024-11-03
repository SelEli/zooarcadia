<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241103210356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE INDEX IDX_966C69DD3DA5256D ON animals (image_id)');
        $this->addSql('ALTER TABLE habitats ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE habitats ADD CONSTRAINT FK_B5E492F33DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('CREATE INDEX IDX_B5E492F33DA5256D ON habitats (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD3DA5256D');
        $this->addSql('DROP INDEX IDX_966C69DD3DA5256D ON animals');
        $this->addSql('ALTER TABLE animals DROP image_id');
        $this->addSql('ALTER TABLE habitats DROP FOREIGN KEY FK_B5E492F33DA5256D');
        $this->addSql('DROP INDEX IDX_B5E492F33DA5256D ON habitats');
        $this->addSql('ALTER TABLE habitats DROP image_id');
    }
}
