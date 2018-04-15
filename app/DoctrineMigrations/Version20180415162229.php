<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180415162229 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sanction (id INT AUTO_INCREMENT NOT NULL, subject INT DEFAULT NULL, issuer INT DEFAULT NULL, date DATETIME NOT NULL, state INT NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, reason VARCHAR(255) NOT NULL, task VARCHAR(255) DEFAULT NULL, INDEX IDX_6D6491AFFBCE3E7A (subject), INDEX IDX_6D6491AFAD7A4F15 (issuer), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sanction ADD CONSTRAINT FK_6D6491AFFBCE3E7A FOREIGN KEY (subject) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sanction ADD CONSTRAINT FK_6D6491AFAD7A4F15 FOREIGN KEY (issuer) REFERENCES user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sanction');
    }
}
