<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225094535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE note_tag (note_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_737A976326ED0855 (note_id), INDEX IDX_737A9763BAD26311 (tag_id), PRIMARY KEY(note_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_folder (note_id INT NOT NULL, folder_id INT NOT NULL, INDEX IDX_F4705E1926ED0855 (note_id), INDEX IDX_F4705E19162CB942 (folder_id), PRIMARY KEY(note_id, folder_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE note_tag ADD CONSTRAINT FK_737A976326ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note_tag ADD CONSTRAINT FK_737A9763BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note_folder ADD CONSTRAINT FK_F4705E1926ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note_folder ADD CONSTRAINT FK_F4705E19162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_note DROP FOREIGN KEY FK_21B245A226ED0855');
        $this->addSql('ALTER TABLE tag_note DROP FOREIGN KEY FK_21B245A2BAD26311');
        $this->addSql('ALTER TABLE folder_note DROP FOREIGN KEY FK_D622DC01162CB942');
        $this->addSql('ALTER TABLE folder_note DROP FOREIGN KEY FK_D622DC0126ED0855');
        $this->addSql('DROP TABLE tag_note');
        $this->addSql('DROP TABLE folder_note');
        $this->addSql('ALTER TABLE folder CHANGE user_id user_id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_CC50EA2672263045 ON langage');
        $this->addSql('ALTER TABLE note CHANGE user_id user_id INT NOT NULL, CHANGE langage_id langage_id INT NOT NULL, CHANGE is_favori is_favori TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_389B783A76ED395 ON tag (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag_note (tag_id INT NOT NULL, note_id INT NOT NULL, INDEX IDX_21B245A2BAD26311 (tag_id), INDEX IDX_21B245A226ED0855 (note_id), PRIMARY KEY(tag_id, note_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE folder_note (folder_id INT NOT NULL, note_id INT NOT NULL, INDEX IDX_D622DC01162CB942 (folder_id), INDEX IDX_D622DC0126ED0855 (note_id), PRIMARY KEY(folder_id, note_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tag_note ADD CONSTRAINT FK_21B245A226ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_note ADD CONSTRAINT FK_21B245A2BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE folder_note ADD CONSTRAINT FK_D622DC01162CB942 FOREIGN KEY (folder_id) REFERENCES folder (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE folder_note ADD CONSTRAINT FK_D622DC0126ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note_tag DROP FOREIGN KEY FK_737A976326ED0855');
        $this->addSql('ALTER TABLE note_tag DROP FOREIGN KEY FK_737A9763BAD26311');
        $this->addSql('ALTER TABLE note_folder DROP FOREIGN KEY FK_F4705E1926ED0855');
        $this->addSql('ALTER TABLE note_folder DROP FOREIGN KEY FK_F4705E19162CB942');
        $this->addSql('DROP TABLE note_tag');
        $this->addSql('DROP TABLE note_folder');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC50EA2672263045 ON langage (technical_name)');
        $this->addSql('ALTER TABLE note CHANGE user_id user_id INT DEFAULT NULL, CHANGE langage_id langage_id INT DEFAULT NULL, CHANGE is_favori is_favori TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE folder CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783A76ED395');
        $this->addSql('DROP INDEX IDX_389B783A76ED395 ON tag');
    }
}
