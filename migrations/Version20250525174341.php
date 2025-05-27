<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250525174341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Préciser comment convertir la colonne date avec USING
        $this->addSql(<<<'SQL'
            ALTER TABLE seminar ALTER COLUMN date TYPE TIMESTAMP(0) WITHOUT TIME ZONE USING date::timestamp(0) without time zone
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seminar ALTER COLUMN date DROP NOT NULL
        SQL);
    }


    public function down(Schema $schema): void
    {
        // Supposons que le type initial était DATE (pas VARCHAR)
        $this->addSql(<<<'SQL'
            ALTER TABLE seminar ALTER COLUMN date TYPE DATE USING date::date
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE seminar ALTER COLUMN date SET NOT NULL
        SQL);
    }

}
