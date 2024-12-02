<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241122203044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            "CREATE TABLE authentication_tokens 
(hash VARCHAR(255) PRIMARY KEY, user_id VARCHAR(255) NOT NULL, expire_at TIMESTAMP NOT NULL)",
        );
    }

    public function down(Schema $schema): void
    {
        $this->connection->executeQuery("DROP TABLE `authentication_tokens`");
    }
}
