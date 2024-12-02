<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124153604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE daily_activity_daily_activities (id VARCHAR(255) NOT NULL, user_id VARCHAR(36) NOT NULL, type VARCHAR(10) NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX user_idx ON daily_activity_daily_activities (user_id)');
        $this->addSql('CREATE INDEX user_date_idx ON daily_activity_daily_activities (user_id, start_at, end_at)');
        $this->addSql('CREATE INDEX user_created_at ON daily_activity_daily_activities (user_id, created_at)');
        $this->addSql('COMMENT ON COLUMN daily_activity_daily_activities.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN daily_activity_daily_activities.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN daily_activity_daily_activities.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE daily_activity_daily_activities');
    }
}
