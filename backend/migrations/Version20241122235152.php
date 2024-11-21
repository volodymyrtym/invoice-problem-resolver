<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241122235152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE daily_activity_daily_activities (id VARCHAR(255) NOT NULL, user_id VARCHAR(36) NOT NULL, type VARCHAR(10) NOT NULL, "from" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, "to" TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX user_idx ON daily_activity_daily_activities (user_id)');
        $this->addSql('CREATE INDEX user_date_idx ON daily_activity_daily_activities (user_id, "from", "to")');
        $this->addSql('COMMENT ON COLUMN daily_activity_daily_activities."from" IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN daily_activity_daily_activities."to" IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_users (id VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, last_login_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, email VARCHAR(320) NOT NULL, password VARCHAR(60) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F6415EB1E7927C74 ON user_users (email)');
        $this->addSql('COMMENT ON COLUMN user_users.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN user_users.last_login_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE daily_activity_daily_activities');
        $this->addSql('DROP TABLE user_users');
    }
}
