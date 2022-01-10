<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220102112255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD commanditaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D3D2F91B5 FOREIGN KEY (commanditaire_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D3D2F91B5 ON commande (commanditaire_id)');
        $this->addSql('ALTER TABLE user ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B1E7706E ON user (restaurant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D3D2F91B5');
        $this->addSql('DROP INDEX IDX_6EEAA67D3D2F91B5 ON commande');
        $this->addSql('ALTER TABLE commande DROP commanditaire_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B1E7706E');
        $this->addSql('DROP INDEX IDX_8D93D649B1E7706E ON user');
        $this->addSql('ALTER TABLE user DROP restaurant_id');
    }
}
