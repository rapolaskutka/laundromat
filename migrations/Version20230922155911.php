<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922155911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF84C8698A54');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF84C8698A54 FOREIGN KEY (dorm_id) REFERENCES dorm (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF84C8698A54');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF84C8698A54 FOREIGN KEY (dorm_id) REFERENCES dorm (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
