<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180415123035 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE group_permission ADD subject_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE group_permission ADD CONSTRAINT FK_3784F318C629992F FOREIGN KEY (subject_group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE INDEX IDX_3784F318C629992F ON group_permission (subject_group_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE group_permission DROP FOREIGN KEY FK_3784F318C629992F');
        $this->addSql('DROP INDEX IDX_3784F318C629992F ON group_permission');
        $this->addSql('ALTER TABLE group_permission DROP subject_group_id');
    }
}
