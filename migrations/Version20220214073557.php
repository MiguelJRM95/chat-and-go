<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220214073557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mensajes DROP FOREIGN KEY salaIdFK');
        $this->addSql('ALTER TABLE sala_files DROP FOREIGN KEY file_salaid');
        $this->addSql('ALTER TABLE usuarios_salas DROP FOREIGN KEY fk_salas_has_usuarios_salas1');
        $this->addSql('ALTER TABLE amigos DROP FOREIGN KEY amigoUnoFK');
        $this->addSql('ALTER TABLE amigos DROP FOREIGN KEY amigoDosFK');
        $this->addSql('ALTER TABLE mensajes DROP FOREIGN KEY nombreUsuarioReceptorFK');
        $this->addSql('ALTER TABLE mensajes DROP FOREIGN KEY nombreUsuarioEmisorFK');
        $this->addSql('ALTER TABLE rec_pass DROP FOREIGN KEY rec_nombreNombreUsuario');
        $this->addSql('ALTER TABLE rec_pass DROP FOREIGN KEY rec_emailEmailUsuario');
        $this->addSql('ALTER TABLE solicitudes DROP FOREIGN KEY nombreReceptorFK');
        $this->addSql('ALTER TABLE solicitudes DROP FOREIGN KEY nombreEmisorFK');
        $this->addSql('ALTER TABLE usuarios_salas DROP FOREIGN KEY fk_salas_has_usuarios_usuarios1');
        $this->addSql('DROP TABLE mensajes');
        $this->addSql('DROP TABLE rec_pass');
        $this->addSql('DROP TABLE sala_files');
        $this->addSql('DROP TABLE salas');
        $this->addSql('DROP TABLE solicitudes');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('ALTER TABLE usuario CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('DROP INDEX usuarios_salaID ON usuarios_salas');
        $this->addSql('DROP INDEX fk_salas_has_usuarios_usuarios1_idx ON usuarios_salas');
        $this->addSql('DROP INDEX fk_salas_has_usuarios_salas1_idx ON usuarios_salas');
        $this->addSql('ALTER TABLE usuarios_salas DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE usuarios_salas ADD usuario_id INT NOT NULL, ADD sala_id INT NOT NULL, DROP usuarios_salaID, DROP salaId, DROP nombreUsuario, DROP estado');
        $this->addSql('ALTER TABLE usuarios_salas ADD CONSTRAINT FK_77DAE93DDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuarios_salas ADD CONSTRAINT FK_77DAE93DC51CDF3F FOREIGN KEY (sala_id) REFERENCES sala (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_77DAE93DDB38439E ON usuarios_salas (usuario_id)');
        $this->addSql('CREATE INDEX IDX_77DAE93DC51CDF3F ON usuarios_salas (sala_id)');
        $this->addSql('ALTER TABLE usuarios_salas ADD PRIMARY KEY (usuario_id, sala_id)');
        $this->addSql('DROP INDEX amigoDosFK ON amigos');
        $this->addSql('DROP INDEX amigoUnoFK ON amigos');
        $this->addSql('ALTER TABLE amigos DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE amigos ADD usuario_id INT NOT NULL, ADD amigo_usuario_id INT NOT NULL, DROP amigosID, DROP nombreUno, DROP nombreDos');
        $this->addSql('ALTER TABLE amigos ADD CONSTRAINT FK_3317FC62DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE amigos ADD CONSTRAINT FK_3317FC621D9B3DB0 FOREIGN KEY (amigo_usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_3317FC62DB38439E ON amigos (usuario_id)');
        $this->addSql('CREATE INDEX IDX_3317FC621D9B3DB0 ON amigos (amigo_usuario_id)');
        $this->addSql('ALTER TABLE amigos ADD PRIMARY KEY (usuario_id, amigo_usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mensajes (mensajeid INT AUTO_INCREMENT NOT NULL, contenido VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nombreUsuarioEmisor VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nombreUsuarioReceptor VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, salaID VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, fecha VARCHAR(350) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, leido TINYINT(1) DEFAULT 0 NOT NULL, INDEX nombreUsuarioReceptorFK (nombreUsuarioReceptor), INDEX salaIdFK (salaID), INDEX nombreUsuarioEmisorFK (nombreUsuarioEmisor), PRIMARY KEY(mensajeid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rec_pass (rec_nombre VARCHAR(250) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, rec_email VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, rec_passId INT AUTO_INCREMENT NOT NULL, rec_reh VARCHAR(250) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, rec_ret VARCHAR(350) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, rec_exp VARCHAR(350) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX rec_nombreNombreUsuario (rec_nombre), INDEX rec_emailEmailUsuario (rec_email), PRIMARY KEY(rec_passId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sala_files (sala_files_id INT AUTO_INCREMENT NOT NULL, salaid VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, mime_type VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, archivo VARCHAR(400) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX file_salaid (salaid), PRIMARY KEY(sala_files_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE salas (salaId VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nombre VARCHAR(120) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, estado TINYINT(1) DEFAULT 1 NOT NULL, PRIMARY KEY(salaId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE solicitudes (solicitudId INT AUTO_INCREMENT NOT NULL, nombreEmisor VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nombreReceptor VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX nombreReceptorFK (nombreReceptor), INDEX nombreEmisorFK (nombreEmisor), PRIMARY KEY(solicitudId)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE usuarios (nombre VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, password VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, avatar LONGBLOB DEFAULT NULL, rol TINYINT(1) DEFAULT 0 NOT NULL, estado TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX email (email), PRIMARY KEY(nombre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE mensajes ADD CONSTRAINT nombreUsuarioReceptorFK FOREIGN KEY (nombreUsuarioReceptor) REFERENCES usuarios (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mensajes ADD CONSTRAINT nombreUsuarioEmisorFK FOREIGN KEY (nombreUsuarioEmisor) REFERENCES usuarios (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mensajes ADD CONSTRAINT salaIdFK FOREIGN KEY (salaID) REFERENCES salas (salaId) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rec_pass ADD CONSTRAINT rec_nombreNombreUsuario FOREIGN KEY (rec_nombre) REFERENCES usuarios (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rec_pass ADD CONSTRAINT rec_emailEmailUsuario FOREIGN KEY (rec_email) REFERENCES usuarios (email) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sala_files ADD CONSTRAINT file_salaid FOREIGN KEY (salaid) REFERENCES salas (salaId) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicitudes ADD CONSTRAINT nombreReceptorFK FOREIGN KEY (nombreReceptor) REFERENCES usuarios (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE solicitudes ADD CONSTRAINT nombreEmisorFK FOREIGN KEY (nombreEmisor) REFERENCES usuarios (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amigos DROP FOREIGN KEY FK_3317FC62DB38439E');
        $this->addSql('ALTER TABLE amigos DROP FOREIGN KEY FK_3317FC621D9B3DB0');
        $this->addSql('DROP INDEX IDX_3317FC62DB38439E ON amigos');
        $this->addSql('DROP INDEX IDX_3317FC621D9B3DB0 ON amigos');
        $this->addSql('ALTER TABLE amigos DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE amigos ADD amigosID INT AUTO_INCREMENT NOT NULL, ADD nombreUno VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, ADD nombreDos VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, DROP usuario_id, DROP amigo_usuario_id');
        $this->addSql('ALTER TABLE amigos ADD CONSTRAINT amigoUnoFK FOREIGN KEY (nombreUno) REFERENCES usuarios (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amigos ADD CONSTRAINT amigoDosFK FOREIGN KEY (nombreDos) REFERENCES usuarios (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX amigoDosFK ON amigos (nombreDos)');
        $this->addSql('CREATE INDEX amigoUnoFK ON amigos (nombreUno)');
        $this->addSql('ALTER TABLE amigos ADD PRIMARY KEY (amigosID)');
        $this->addSql('ALTER TABLE mensaje CHANGE contenido contenido VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fecha fecha VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tipo tipo VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE perfil CHANGE nombre nombre VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE apellido_uno apellido_uno VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE apellido_dos apellido_dos VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE frase_estado frase_estado VARCHAR(150) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE avatar avatar VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE direccion direccion VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE sala CHANGE nombre_sala nombre_sala VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE usuario CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE usuarios_salas DROP FOREIGN KEY FK_77DAE93DDB38439E');
        $this->addSql('ALTER TABLE usuarios_salas DROP FOREIGN KEY FK_77DAE93DC51CDF3F');
        $this->addSql('DROP INDEX IDX_77DAE93DDB38439E ON usuarios_salas');
        $this->addSql('DROP INDEX IDX_77DAE93DC51CDF3F ON usuarios_salas');
        $this->addSql('ALTER TABLE usuarios_salas DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE usuarios_salas ADD usuarios_salaID INT AUTO_INCREMENT NOT NULL, ADD salaId VARCHAR(200) NOT NULL COLLATE `utf8mb4_general_ci`, ADD nombreUsuario VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, ADD estado TINYINT(1) DEFAULT 1 NOT NULL, DROP usuario_id, DROP sala_id');
        $this->addSql('ALTER TABLE usuarios_salas ADD CONSTRAINT fk_salas_has_usuarios_usuarios1 FOREIGN KEY (nombreUsuario) REFERENCES usuarios (nombre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuarios_salas ADD CONSTRAINT fk_salas_has_usuarios_salas1 FOREIGN KEY (salaId) REFERENCES salas (salaId) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX usuarios_salaID ON usuarios_salas (usuarios_salaID)');
        $this->addSql('CREATE INDEX fk_salas_has_usuarios_usuarios1_idx ON usuarios_salas (nombreUsuario)');
        $this->addSql('CREATE INDEX fk_salas_has_usuarios_salas1_idx ON usuarios_salas (salaId)');
        $this->addSql('ALTER TABLE usuarios_salas ADD PRIMARY KEY (salaId, nombreUsuario, usuarios_salaID)');
    }
}
