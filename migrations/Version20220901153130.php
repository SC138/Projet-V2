<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901153130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE date_user ADD relation_id INT DEFAULT NULL, ADD date_meet DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE date_user ADD CONSTRAINT FK_AD4D5FBD3256915B FOREIGN KEY (relation_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AD4D5FBD3256915B ON date_user (relation_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64983A00E68 ON user (firstname)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE date_user DROP FOREIGN KEY FK_AD4D5FBD3256915B');
        $this->addSql('DROP INDEX UNIQ_AD4D5FBD3256915B ON date_user');
        $this->addSql('ALTER TABLE date_user DROP relation_id, DROP date_meet');
        $this->addSql('DROP INDEX UNIQ_8D93D64983A00E68 ON user');
    }
}
