<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529072128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intl_transaction DROP FOREIGN KEY FK_9719BB21386D8D01');
        $this->addSql('DROP INDEX IDX_9719BB21386D8D01 ON intl_transaction');
        $this->addSql('ALTER TABLE intl_transaction CHANGE receptor_id recipient_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intl_transaction ADD CONSTRAINT FK_9719BB21E92F8F78 FOREIGN KEY (recipient_id) REFERENCES receptor (id)');
        $this->addSql('CREATE INDEX IDX_9719BB21E92F8F78 ON intl_transaction (recipient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE intl_transaction DROP FOREIGN KEY FK_9719BB21E92F8F78');
        $this->addSql('DROP INDEX IDX_9719BB21E92F8F78 ON intl_transaction');
        $this->addSql('ALTER TABLE intl_transaction CHANGE recipient_id receptor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intl_transaction ADD CONSTRAINT FK_9719BB21386D8D01 FOREIGN KEY (receptor_id) REFERENCES receptor (id)');
        $this->addSql('CREATE INDEX IDX_9719BB21386D8D01 ON intl_transaction (receptor_id)');
    }
}
