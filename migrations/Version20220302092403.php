<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220302092403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sala CHANGE estado estado TINYINT(1) DEFAULT 1');
        $this->addSql('ALTER TABLE usuario ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mensaje CHANGE contenido contenido VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fecha fecha VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tipo tipo VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE perfil CHANGE nombre nombre VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE apellido_uno apellido_uno VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE apellido_dos apellido_dos VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE frase_estado frase_estado VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE avatar avatar VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE direccion direccion VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sala CHANGE nombre_sala nombre_sala VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE estado estado TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE usuario DROP is_active, CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
