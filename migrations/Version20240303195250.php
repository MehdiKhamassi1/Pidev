<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303195250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, docteur_id INT DEFAULT NULL, dossiermedical_id INT DEFAULT NULL, date_consultation DATE NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_964685A66B899279 (patient_id), UNIQUE INDEX UNIQ_964685A6CF22540A (docteur_id), INDEX IDX_964685A6DAFFF6DA (dossiermedical_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossiermedical (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, groupesang VARCHAR(255) NOT NULL, maladie_chronique VARCHAR(255) NOT NULL, resultat_analyse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6699B4F06B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6CF22540A FOREIGN KEY (docteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6DAFFF6DA FOREIGN KEY (dossiermedical_id) REFERENCES dossiermedical (id)');
        $this->addSql('ALTER TABLE dossiermedical ADD CONSTRAINT FK_6699B4F06B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D99E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064046B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404CF22540A FOREIGN KEY (docteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230C6B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230CCF22540A FOREIGN KEY (docteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230C5D5A2101 FOREIGN KEY (local_id) REFERENCES local (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B946230CA76ED395 ON rendezvouz (user_id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66B899279');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6CF22540A');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6DAFFF6DA');
        $this->addSql('ALTER TABLE dossiermedical DROP FOREIGN KEY FK_6699B4F06B899279');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE dossiermedical');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D99E6B1585');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779A76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064046B899279');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404CF22540A');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE reclamation CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230C6B899279');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230CCF22540A');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230C5D5A2101');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230CA76ED395');
        $this->addSql('DROP INDEX IDX_B946230CA76ED395 ON rendezvouz');
        $this->addSql('ALTER TABLE rendezvouz DROP user_id');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9');
    }
}
