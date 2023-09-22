<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922162422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dorm DROP FOREIGN KEY FK_F88135C44B09E92C');
        $this->addSql('ALTER TABLE dorm ADD CONSTRAINT FK_F88135C44B09E92C FOREIGN KEY (administrator_id) REFERENCES `user` (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dorm DROP FOREIGN KEY FK_F88135C44B09E92C');
        $this->addSql('ALTER TABLE dorm ADD CONSTRAINT FK_F88135C44B09E92C FOREIGN KEY (administrator_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
