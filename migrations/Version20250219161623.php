<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250219161623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE file_note (file_id INT NOT NULL, note_id INT NOT NULL, INDEX IDX_4641927A93CB796C (file_id), INDEX IDX_4641927A26ED0855 (note_id), PRIMARY KEY(file_id, note_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_file (note_id INT NOT NULL, file_id INT NOT NULL, INDEX IDX_2CE5274826ED0855 (note_id), INDEX IDX_2CE5274893CB796C (file_id), PRIMARY KEY(note_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_note ADD CONSTRAINT FK_4641927A93CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE file_note ADD CONSTRAINT FK_4641927A26ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note_file ADD CONSTRAINT FK_2CE5274826ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note_file ADD CONSTRAINT FK_2CE5274893CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file_note DROP FOREIGN KEY FK_4641927A93CB796C');
        $this->addSql('ALTER TABLE file_note DROP FOREIGN KEY FK_4641927A26ED0855');
        $this->addSql('ALTER TABLE note_file DROP FOREIGN KEY FK_2CE5274826ED0855');
        $this->addSql('ALTER TABLE note_file DROP FOREIGN KEY FK_2CE5274893CB796C');
        $this->addSql('DROP TABLE file_note');
        $this->addSql('DROP TABLE note_file');
    }
}
