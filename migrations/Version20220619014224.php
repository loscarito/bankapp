<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220619014224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, account_no INT NOT NULL, is_active TINYINT(1) NOT NULL, balance BIGINT NOT NULL, withdraw INT NOT NULL, deposit INT NOT NULL, payment INT NOT NULL, UNIQUE INDEX UNIQ_7D3656A4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CFF65260F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, src VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intl_transaction (id INT NOT NULL, receptor_id INT DEFAULT NULL, INDEX IDX_9719BB21386D8D01 (receptor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE loan (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, amount INT NOT NULL, duration INT NOT NULL, date DATETIME NOT NULL, detail VARCHAR(255) NOT NULL, is_approved TINYINT(1) NOT NULL, INDEX IDX_C5D30D03A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, fromu VARCHAR(255) NOT NULL, fromemail VARCHAR(255) NOT NULL, smalldesc VARCHAR(255) NOT NULL, toa VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, is_read TINYINT(1) NOT NULL, content VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, date DATETIME NOT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE norm_transaction (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, number INT NOT NULL, new INT NOT NULL, contenu VARCHAR(255) NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE receptor (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, swift VARCHAR(255) NOT NULL, iban VARCHAR(255) NOT NULL, account_no BIGINT NOT NULL, pays VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, postal VARCHAR(255) NOT NULL, tel BIGINT NOT NULL, verificode INT NOT NULL, is_verify TINYINT(1) NOT NULL, date DATETIME NOT NULL, INDEX IDX_E9C2A867A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, date DATETIME NOT NULL, reference INT NOT NULL, description VARCHAR(255) NOT NULL, is_debit TINYINT(1) NOT NULL, is_credit TINYINT(1) NOT NULL, amount BIGINT NOT NULL, status VARCHAR(255) NOT NULL, level INT NOT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_723705D19B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, compte_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, countries VARCHAR(255) NOT NULL, states VARCHAR(255) NOT NULL, cities VARCHAR(255) NOT NULL, date DATETIME NOT NULL, address VARCHAR(255) NOT NULL, eligible TINYINT(1) NOT NULL, employer VARCHAR(255) NOT NULL, employee VARCHAR(255) NOT NULL, salary INT NOT NULL, security1 VARCHAR(255) NOT NULL, security2 VARCHAR(255) NOT NULL, security3 VARCHAR(255) NOT NULL, answer1 VARCHAR(255) NOT NULL, answer2 VARCHAR(255) NOT NULL, answer3 VARCHAR(255) NOT NULL, postal VARCHAR(255) NOT NULL, pin INT NOT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D6493DA5256D (image_id), UNIQUE INDEX UNIQ_8D93D649F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE intl_transaction ADD CONSTRAINT FK_9719BB21386D8D01 FOREIGN KEY (receptor_id) REFERENCES receptor (id)');
        $this->addSql('ALTER TABLE intl_transaction ADD CONSTRAINT FK_9719BB21BF396750 FOREIGN KEY (id) REFERENCES transaction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE loan ADD CONSTRAINT FK_C5D30D03A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE norm_transaction ADD CONSTRAINT FK_F64F0A8FBF396750 FOREIGN KEY (id) REFERENCES transaction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE receptor ADD CONSTRAINT FK_E9C2A867A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D19B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D19B6B5FBA');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F2C56620');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493DA5256D');
        $this->addSql('ALTER TABLE intl_transaction DROP FOREIGN KEY FK_9719BB21386D8D01');
        $this->addSql('ALTER TABLE intl_transaction DROP FOREIGN KEY FK_9719BB21BF396750');
        $this->addSql('ALTER TABLE norm_transaction DROP FOREIGN KEY FK_F64F0A8FBF396750');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4A76ED395');
        $this->addSql('ALTER TABLE loan DROP FOREIGN KEY FK_C5D30D03A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE receptor DROP FOREIGN KEY FK_E9C2A867A76ED395');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE intl_transaction');
        $this->addSql('DROP TABLE loan');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE norm_transaction');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE receptor');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
    }
}
