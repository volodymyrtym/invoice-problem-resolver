<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201235228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX user_created_at');
        $this->addSql('ALTER TABLE daily_activity_daily_activities DROP type');
        $this->addSql('CREATE INDEX user_idx ON daily_activity_daily_activities (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX user_idx');
        $this->addSql('ALTER TABLE daily_activity_daily_activities ADD type VARCHAR(10) NOT NULL');
        $this->addSql('CREATE INDEX user_created_at ON daily_activity_daily_activities (user_id, created_at)');
    }
}
