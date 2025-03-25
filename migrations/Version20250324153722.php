<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250324153722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE mail email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE folder CHANGE user_id user_id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_CC50EA2672263045 ON langage');
        $this->addSql('ALTER TABLE note CHANGE user_id user_id INT NOT NULL, CHANGE langage_id langage_id INT NOT NULL, CHANGE is_favori is_favori TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX `primary` ON note_tag');
        $this->addSql('ALTER TABLE note_tag ADD PRIMARY KEY (note_id, tag_id)');
        $this->addSql('ALTER TABLE note_tag RENAME INDEX idx_21b245a226ed0855 TO IDX_737A976326ED0855');
        $this->addSql('ALTER TABLE note_tag RENAME INDEX idx_21b245a2bad26311 TO IDX_737A9763BAD26311');
        $this->addSql('DROP INDEX `primary` ON note_folder');
        $this->addSql('ALTER TABLE note_folder ADD PRIMARY KEY (note_id, folder_id)');
        $this->addSql('ALTER TABLE note_folder RENAME INDEX idx_d622dc0126ed0855 TO IDX_F4705E1926ED0855');
        $this->addSql('ALTER TABLE note_folder RENAME INDEX idx_d622dc01162cb942 TO IDX_F4705E19162CB942');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_389B783A76ED395 ON tag (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE email mail VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE note CHANGE user_id user_id INT DEFAULT NULL, CHANGE langage_id langage_id INT DEFAULT NULL, CHANGE is_favori is_favori TINYINT(1) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC50EA2672263045 ON langage (technical_name)');
        $this->addSql('DROP INDEX `PRIMARY` ON note_folder');
        $this->addSql('ALTER TABLE note_folder ADD PRIMARY KEY (folder_id, note_id)');
        $this->addSql('ALTER TABLE note_folder RENAME INDEX idx_f4705e19162cb942 TO IDX_D622DC01162CB942');
        $this->addSql('ALTER TABLE note_folder RENAME INDEX idx_f4705e1926ed0855 TO IDX_D622DC0126ED0855');
        $this->addSql('DROP INDEX `PRIMARY` ON note_tag');
        $this->addSql('ALTER TABLE note_tag ADD PRIMARY KEY (tag_id, note_id)');
        $this->addSql('ALTER TABLE note_tag RENAME INDEX idx_737a976326ed0855 TO IDX_21B245A226ED0855');
        $this->addSql('ALTER TABLE note_tag RENAME INDEX idx_737a9763bad26311 TO IDX_21B245A2BAD26311');
        $this->addSql('ALTER TABLE folder CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783A76ED395');
        $this->addSql('DROP INDEX IDX_389B783A76ED395 ON tag');
    }
}
