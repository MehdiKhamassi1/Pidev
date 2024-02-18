<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240210154916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, contenu VARCHAR(255) NOT NULL, publication_id INT DEFAULT NULL, INDEX IDX_67F068BC38B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE docteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE local (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, contenu VARCHAR(255) NOT NULL, patient_id INT DEFAULT NULL, docteur_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_AF3C67796B899279 (patient_id), UNIQUE INDEX UNIQ_AF3C6779CF22540A (docteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, patient_id INT DEFAULT NULL, docteur_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_CE6064046B899279 (patient_id), UNIQUE INDEX UNIQ_CE606404CF22540A (docteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE rendezvouz (id INT AUTO_INCREMENT NOT NULL, daterdv VARCHAR(255) NOT NULL, patient_id INT DEFAULT NULL, docteur_id INT DEFAULT NULL, local_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_B946230C6B899279 (patient_id), UNIQUE INDEX UNIQ_B946230CCF22540A (docteur_id), INDEX IDX_B946230C5D5A2101 (local_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, response VARCHAR(255) NOT NULL, reclamation_id INT DEFAULT NULL, INDEX IDX_5FB6DEC72D6BA2D9 (reclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67796B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779CF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064046B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404CF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230C6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230CCF22540A FOREIGN KEY (docteur_id) REFERENCES docteur (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230C5D5A2101 FOREIGN KEY (local_id) REFERENCES local (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67796B899279');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779CF22540A');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064046B899279');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404CF22540A');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230C6B899279');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230CCF22540A');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230C5D5A2101');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE docteur');
        $this->addSql('DROP TABLE local');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE rendezvouz');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
