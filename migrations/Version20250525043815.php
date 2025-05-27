<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250525043815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SEQUENCE notification_subscriber_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE notification_subscriber (id INT NOT NULL, email VARCHAR(180) NOT NULL, subscribed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_5672FE4BE7927C74 ON notification_subscriber (email)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN notification_subscriber.subscribed_at IS '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seminar ALTER date TYPE VARCHAR(255)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            DROP SEQUENCE notification_subscriber_id_seq CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE notification_subscriber
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seminar ALTER date TYPE TIMESTAMP(0) WITHOUT TIME ZONE
        SQL);
    }
}
