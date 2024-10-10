<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009134750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init database';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id UUID NOT NULL, question_id UUID DEFAULT NULL, text TEXT NOT NULL, is_correct BOOLEAN NOT NULL, is_fuzzy_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('COMMENT ON COLUMN answer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN answer.question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE question (id UUID NOT NULL, text TEXT NOT NULL, is_fuzzy BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN question.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE test_result (id UUID NOT NULL, test_id UUID NOT NULL, question TEXT NOT NULL, answers JSON NOT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_84B3C63D1E5D0459 ON test_result (test_id)');
        $this->addSql('COMMENT ON COLUMN test_result.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN test_result.test_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE tests (id UUID NOT NULL, completed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN tests.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tests.completed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE test_result ADD CONSTRAINT FK_84B3C63D1E5D0459 FOREIGN KEY (test_id) REFERENCES tests (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE test_result DROP CONSTRAINT FK_84B3C63D1E5D0459');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE test_result');
        $this->addSql('DROP TABLE tests');
    }
}
