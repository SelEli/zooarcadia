<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104204434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals DROP FOREIGN KEY FK_966C69DD6E59D40D');
        $this->addSql('DROP INDEX IDX_966C69DD6E59D40D ON animals');
        $this->addSql('ALTER TABLE animals DROP race_id, DROP food, DROP food_quantity, DROP visit_date');
        $this->addSql('ALTER TABLE images ADD habitat_id INT DEFAULT NULL, ADD animal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8E962C16 FOREIGN KEY (animal_id) REFERENCES animals (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6AAFFE2D26 ON images (habitat_id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A8E962C16 ON images (animal_id)');
        $this->addSql('ALTER TABLE tasks DROP habitat_comment, DROP animal_report, DROP food_consumption');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animals ADD race_id INT DEFAULT NULL, ADD food LONGTEXT DEFAULT NULL, ADD food_quantity INT DEFAULT NULL, ADD visit_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE animals ADD CONSTRAINT FK_966C69DD6E59D40D FOREIGN KEY (race_id) REFERENCES races (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_966C69DD6E59D40D ON animals (race_id)');
        $this->addSql('ALTER TABLE tasks ADD habitat_comment LONGTEXT DEFAULT NULL, ADD animal_report LONGTEXT DEFAULT NULL, ADD food_consumption LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAFFE2D26');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8E962C16');
        $this->addSql('DROP INDEX IDX_E01FBE6AAFFE2D26 ON images');
        $this->addSql('DROP INDEX IDX_E01FBE6A8E962C16 ON images');
        $this->addSql('ALTER TABLE images DROP habitat_id, DROP animal_id');
    }
}
