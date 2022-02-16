<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220216185607 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mensaje (id INT AUTO_INCREMENT NOT NULL, usuario_emisor_id INT NOT NULL, usuario_receptor_id INT NOT NULL, sala_id INT NOT NULL, contenido VARCHAR(255) NOT NULL, fecha VARCHAR(255) NOT NULL, tipo VARCHAR(255) NOT NULL, INDEX IDX_9B631D01E2E46DCD (usuario_emisor_id), INDEX IDX_9B631D01467F8F (usuario_receptor_id), INDEX IDX_9B631D01C51CDF3F (sala_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE perfil (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, apellido_uno VARCHAR(255) DEFAULT NULL, apellido_dos VARCHAR(255) DEFAULT NULL, frase_estado VARCHAR(150) DEFAULT NULL, avatar VARCHAR(255) NOT NULL, direccion VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE peticion (id INT AUTO_INCREMENT NOT NULL, usuario_receptor_id INT NOT NULL, usuario_emisor_id INT NOT NULL, estado TINYINT(1) NOT NULL, INDEX IDX_3297E425467F8F (usuario_receptor_id), INDEX IDX_3297E425E2E46DCD (usuario_emisor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sala (id INT AUTO_INCREMENT NOT NULL, nombre_sala VARCHAR(255) NOT NULL, estado TINYINT(1) DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, perfil_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2265B05DF85E0677 (username), UNIQUE INDEX UNIQ_2265B05D57291544 (perfil_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuarios_salas (usuario_id INT NOT NULL, sala_id INT NOT NULL, INDEX IDX_77DAE93DDB38439E (usuario_id), INDEX IDX_77DAE93DC51CDF3F (sala_id), PRIMARY KEY(usuario_id, sala_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amigos (usuario_id INT NOT NULL, amigo_usuario_id INT NOT NULL, INDEX IDX_3317FC62DB38439E (usuario_id), INDEX IDX_3317FC621D9B3DB0 (amigo_usuario_id), PRIMARY KEY(usuario_id, amigo_usuario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mensaje ADD CONSTRAINT FK_9B631D01E2E46DCD FOREIGN KEY (usuario_emisor_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE mensaje ADD CONSTRAINT FK_9B631D01467F8F FOREIGN KEY (usuario_receptor_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE mensaje ADD CONSTRAINT FK_9B631D01C51CDF3F FOREIGN KEY (sala_id) REFERENCES sala (id)');
        $this->addSql('ALTER TABLE peticion ADD CONSTRAINT FK_3297E425467F8F FOREIGN KEY (usuario_receptor_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE peticion ADD CONSTRAINT FK_3297E425E2E46DCD FOREIGN KEY (usuario_emisor_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D57291544 FOREIGN KEY (perfil_id) REFERENCES perfil (id)');
        $this->addSql('ALTER TABLE usuarios_salas ADD CONSTRAINT FK_77DAE93DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuarios_salas ADD CONSTRAINT FK_77DAE93DC51CDF3F FOREIGN KEY (sala_id) REFERENCES sala (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amigos ADD CONSTRAINT FK_3317FC62DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE amigos ADD CONSTRAINT FK_3317FC621D9B3DB0 FOREIGN KEY (amigo_usuario_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D57291544');
        $this->addSql('ALTER TABLE mensaje DROP FOREIGN KEY FK_9B631D01C51CDF3F');
        $this->addSql('ALTER TABLE usuarios_salas DROP FOREIGN KEY FK_77DAE93DC51CDF3F');
        $this->addSql('ALTER TABLE mensaje DROP FOREIGN KEY FK_9B631D01E2E46DCD');
        $this->addSql('ALTER TABLE mensaje DROP FOREIGN KEY FK_9B631D01467F8F');
        $this->addSql('ALTER TABLE peticion DROP FOREIGN KEY FK_3297E425467F8F');
        $this->addSql('ALTER TABLE peticion DROP FOREIGN KEY FK_3297E425E2E46DCD');
        $this->addSql('ALTER TABLE usuarios_salas DROP FOREIGN KEY FK_77DAE93DDB38439E');
        $this->addSql('ALTER TABLE amigos DROP FOREIGN KEY FK_3317FC62DB38439E');
        $this->addSql('ALTER TABLE amigos DROP FOREIGN KEY FK_3317FC621D9B3DB0');
        $this->addSql('DROP TABLE mensaje');
        $this->addSql('DROP TABLE perfil');
        $this->addSql('DROP TABLE peticion');
        $this->addSql('DROP TABLE sala');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE usuarios_salas');
        $this->addSql('DROP TABLE amigos');
    }
}
