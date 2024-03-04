<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240302200217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rendezvouz (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, docteur_id INT DEFAULT NULL, local_id INT DEFAULT NULL, user_id INT DEFAULT NULL, daterdv DATETIME NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B946230C6B899279 (patient_id), UNIQUE INDEX UNIQ_B946230CCF22540A (docteur_id), INDEX IDX_B946230C5D5A2101 (local_id), INDEX IDX_B946230CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230C6B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230CCF22540A FOREIGN KEY (docteur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230C5D5A2101 FOREIGN KEY (local_id) REFERENCES local (id)');
        $this->addSql('ALTER TABLE rendezvouz ADD CONSTRAINT FK_B946230CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D99E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE date date DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230C6B899279');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230CCF22540A');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230C5D5A2101');
        $this->addSql('ALTER TABLE rendezvouz DROP FOREIGN KEY FK_B946230CA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE rendezvouz');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D99E6B1585');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779A76ED395');
        $this->addSql('ALTER TABLE reclamation CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE reponse CHANGE date date DATETIME DEFAULT CURRENT_TIMESTAMP');
    }
}
