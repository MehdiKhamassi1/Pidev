<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240210225918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, docteur_id INT DEFAULT NULL, dossiermedical_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_964685A66B899279 (patient_id), UNIQUE INDEX UNIQ_964685A6CF22540A (docteur_id), INDEX IDX_964685A6DAFFF6DA (dossiermedical_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE don (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, valeur VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, organisation_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, docteur_id INT DEFAULT NULL, INDEX IDX_F8F081D99E6B1585 (organisation_id), UNIQUE INDEX UNIQ_F8F081D96B899279 (patient_id), UNIQUE INDEX UNIQ_F8F081D9CF22540A (docteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE dossiermedical (id INT AUTO_INCREMENT NOT NULL, groupesang VARCHAR(255) NOT NULL, patient_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_6699B4F06B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE organisation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6CF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6DAFFF6DA FOREIGN KEY (dossiermedical_id) REFERENCES dossiermedical (id)');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D99E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D96B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D9CF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE dossiermedical ADD CONSTRAINT FK_6699B4F06B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6CF22540A');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6DAFFF6DA');
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D99E6B1585');
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D96B899279');
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D9CF22540A');
        $this->addSql('ALTER TABLE dossiermedical DROP FOREIGN KEY FK_6699B4F06B899279');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE don');
        $this->addSql('DROP TABLE dossiermedical');
        $this->addSql('DROP TABLE organisation');
    }
}
