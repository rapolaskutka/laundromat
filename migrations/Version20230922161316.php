<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230922161316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF84C8698A54');
        $this->addSql('DROP INDEX IDX_1505DF84C8698A54 ON machine');
        $this->addSql('ALTER TABLE machine CHANGE dorm_id dorm INT DEFAULT NULL');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF84F88135C4 FOREIGN KEY (dorm) REFERENCES dorm (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_1505DF84F88135C4 ON machine (dorm)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF84F88135C4');
        $this->addSql('DROP INDEX IDX_1505DF84F88135C4 ON machine');
        $this->addSql('ALTER TABLE machine CHANGE dorm dorm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF84C8698A54 FOREIGN KEY (dorm_id) REFERENCES dorm (id) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_1505DF84C8698A54 ON machine (dorm_id)');
    }
}
