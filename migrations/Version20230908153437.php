<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230908153437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postuler_jobs DROP FOREIGN KEY FK_E6A4CE4A48704627');
        $this->addSql('ALTER TABLE postuler_jobs DROP FOREIGN KEY FK_E6A4CE4A9CFF603D');
        $this->addSql('ALTER TABLE postuler_user DROP FOREIGN KEY FK_C3A475C69CFF603D');
        $this->addSql('ALTER TABLE postuler_user DROP FOREIGN KEY FK_C3A475C6A76ED395');
        $this->addSql('DROP TABLE postuler_jobs');
        $this->addSql('DROP TABLE postuler_user');
        $this->addSql('ALTER TABLE postuler ADD auteur_id INT NOT NULL, ADD offres_id INT NOT NULL');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68D60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE postuler ADD CONSTRAINT FK_8EC5A68D6C83CD9F FOREIGN KEY (offres_id) REFERENCES jobs (id)');
        $this->addSql('CREATE INDEX IDX_8EC5A68D60BB6FE6 ON postuler (auteur_id)');
        $this->addSql('CREATE INDEX IDX_8EC5A68D6C83CD9F ON postuler (offres_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE postuler_jobs (postuler_id INT NOT NULL, jobs_id INT NOT NULL, INDEX IDX_E6A4CE4A9CFF603D (postuler_id), INDEX IDX_E6A4CE4A48704627 (jobs_id), PRIMARY KEY(postuler_id, jobs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE postuler_user (postuler_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C3A475C69CFF603D (postuler_id), INDEX IDX_C3A475C6A76ED395 (user_id), PRIMARY KEY(postuler_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE postuler_jobs ADD CONSTRAINT FK_E6A4CE4A48704627 FOREIGN KEY (jobs_id) REFERENCES jobs (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postuler_jobs ADD CONSTRAINT FK_E6A4CE4A9CFF603D FOREIGN KEY (postuler_id) REFERENCES postuler (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postuler_user ADD CONSTRAINT FK_C3A475C69CFF603D FOREIGN KEY (postuler_id) REFERENCES postuler (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postuler_user ADD CONSTRAINT FK_C3A475C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68D60BB6FE6');
        $this->addSql('ALTER TABLE postuler DROP FOREIGN KEY FK_8EC5A68D6C83CD9F');
        $this->addSql('DROP INDEX IDX_8EC5A68D60BB6FE6 ON postuler');
        $this->addSql('DROP INDEX IDX_8EC5A68D6C83CD9F ON postuler');
        $this->addSql('ALTER TABLE postuler DROP auteur_id, DROP offres_id');
    }
}
