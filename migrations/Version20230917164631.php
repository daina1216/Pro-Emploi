<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230917164631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler ADD accept VARCHAR(255) DEFAULT NULL, ADD refuser VARCHAR(255) NOT NULL, ADD refuse VARCHAR(255) DEFAULT NULL, DROP is_accept');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler ADD is_accept TINYINT(1) DEFAULT NULL, DROP accept, DROP refuser, DROP refuse');
    }
}
