<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211231103053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, rst_commande_id INT DEFAULT NULL, prix_tt INT DEFAULT NULL, INDEX IDX_6EEAA67D32C8B293 (rst_commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignecommande (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_853B7939F347EFB (produit_id), INDEX IDX_853B793982EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, point_vente_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_29A5EC27EFA24D68 (point_vente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D32C8B293 FOREIGN KEY (rst_commande_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B7939F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE lignecommande ADD CONSTRAINT FK_853B793982EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27EFA24D68 FOREIGN KEY (point_vente_id) REFERENCES restaurant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_853B793982EA2E54');
        $this->addSql('ALTER TABLE lignecommande DROP FOREIGN KEY FK_853B7939F347EFB');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D32C8B293');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27EFA24D68');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE lignecommande');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE restaurant');
    }
}
