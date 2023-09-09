<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230909183625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'relations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dorm (id INT AUTO_INCREMENT NOT NULL, administrator_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, INDEX IDX_F88135C44B09E92C (administrator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dorm ADD CONSTRAINT FK_F88135C44B09E92C FOREIGN KEY (administrator_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE machine ADD dorm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE machine ADD CONSTRAINT FK_1505DF84C8698A54 FOREIGN KEY (dorm_id) REFERENCES dorm (id)');
        $this->addSql('CREATE INDEX IDX_1505DF84C8698A54 ON machine (dorm_id)');
        $this->addSql('ALTER TABLE user ADD dorm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C8698A54 FOREIGN KEY (dorm_id) REFERENCES dorm (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649C8698A54 ON user (dorm_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE machine DROP FOREIGN KEY FK_1505DF84C8698A54');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649C8698A54');
        $this->addSql('ALTER TABLE dorm DROP FOREIGN KEY FK_F88135C44B09E92C');
        $this->addSql('DROP TABLE dorm');
        $this->addSql('DROP INDEX IDX_1505DF84C8698A54 ON machine');
        $this->addSql('ALTER TABLE machine DROP dorm_id');
        $this->addSql('DROP INDEX IDX_8D93D649C8698A54 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP dorm_id');
    }
}
