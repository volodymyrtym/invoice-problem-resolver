<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124233426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX user_date_idx');
        $this->addSql('DROP INDEX user_idx');
        $this->addSql('CREATE INDEX user_start_date_idx ON daily_activity_daily_activities (user_id, start_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX user_start_date_idx');
        $this->addSql('CREATE INDEX user_date_idx ON daily_activity_daily_activities (user_id, start_at, end_at)');
        $this->addSql('CREATE INDEX user_idx ON daily_activity_daily_activities (user_id)');
    }
}
