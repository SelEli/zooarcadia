<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107130642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8E962C16');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAFFE2D26');
        $this->addSql('DROP INDEX IDX_E01FBE6AAFFE2D26 ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A8E962C16 ON images');
        $this->addSql('ALTER TABLE images ADD data LONGBLOB NOT NULL, DROP habitat_id, DROP animal_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD habitat_id INT DEFAULT NULL, ADD animal_id INT DEFAULT NULL, DROP data');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_E01FBE6AAFFE2D26 ON images (habitat_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A8E962C16 ON images (animal_id)');
    }
}
