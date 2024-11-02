<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102205856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD3DA5256D');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD6E59D40D');
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DDAFFE2D26');
        $this->addSql('DROP INDEX IDX_966C69DD6E59D40D ON animals');
        $this->addSql('DROP INDEX IDX_966C69DDAFFE2D26 ON animals');
        $this->addSql('DROP INDEX IDX_966C69DD3DA5256D ON animals');
        $this->addSql('ALTER TABLE animals DROP race_id, DROP habitat_id, DROP image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals ADD race_id INT DEFAULT NULL, ADD habitat_id INT DEFAULT NULL, ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD6E59D40D FOREIGN KEY (race_id) REFERENCES races (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DDAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_966C69DD6E59D40D ON animals (race_id)');
        $this->addSql('CREATE INDEX IDX_966C69DDAFFE2D26 ON animals (habitat_id)');
        $this->addSql('CREATE INDEX IDX_966C69DD3DA5256D ON animals (image_id)');
    }
}
