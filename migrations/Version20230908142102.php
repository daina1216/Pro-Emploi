<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908142102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE postuler (id INT AUTO_INCREMENT NOT NULL, create_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postuler_user (postuler_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C3A475C69CFF603D (postuler_id), INDEX IDX_C3A475C6A76ED395 (user_id), PRIMARY KEY(postuler_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postuler_jobs (postuler_id INT NOT NULL, jobs_id INT NOT NULL, INDEX IDX_E6A4CE4A9CFF603D (postuler_id), INDEX IDX_E6A4CE4A48704627 (jobs_id), PRIMARY KEY(postuler_id, jobs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE postuler_user ADD CONSTRAINT FK_C3A475C69CFF603D FOREIGN KEY (postuler_id) REFERENCES postuler (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postuler_user ADD CONSTRAINT FK_C3A475C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postuler_jobs ADD CONSTRAINT FK_E6A4CE4A9CFF603D FOREIGN KEY (postuler_id) REFERENCES postuler (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postuler_jobs ADD CONSTRAINT FK_E6A4CE4A48704627 FOREIGN KEY (jobs_id) REFERENCES jobs (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler_user DROP FOREIGN KEY FK_C3A475C69CFF603D');
        $this->addSql('ALTER TABLE postuler_user DROP FOREIGN KEY FK_C3A475C6A76ED395');
        $this->addSql('ALTER TABLE postuler_jobs DROP FOREIGN KEY FK_E6A4CE4A9CFF603D');
        $this->addSql('ALTER TABLE postuler_jobs DROP FOREIGN KEY FK_E6A4CE4A48704627');
        $this->addSql('DROP TABLE postuler');
        $this->addSql('DROP TABLE postuler_user');
        $this->addSql('DROP TABLE postuler_jobs');
    }
}
