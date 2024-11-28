<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241128170421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE authentication_tokens');
        $this->addSql('CREATE TABLE authentication_tokens (
            id SERIAL PRIMARY KEY, 
            hash VARCHAR(64) NOT NULL, 
            user_id VARCHAR(36) NOT NULL, 
            expire_at TIMESTAMP NOT NULL,
            CONSTRAINT UQ_HASH UNIQUE (hash),
            CONSTRAINT UQ_USER_ID UNIQUE (user_id)
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE authentication_tokens');
    }
}
