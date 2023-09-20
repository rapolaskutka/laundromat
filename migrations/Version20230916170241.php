<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230916170241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, machine_id INT DEFAULT NULL, start_date DATETIME NOT NULL, end_date DATETIME DEFAULT NULL, INDEX IDX_27BA704BA76ED395 (user_id), INDEX IDX_27BA704BF6B75B26 (machine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BF6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BA76ED395');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BF6B75B26');
        $this->addSql('DROP TABLE history');
    }
}
