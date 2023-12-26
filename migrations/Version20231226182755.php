<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231226182755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment ADD added_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD validated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D55B127A4 FOREIGN KEY (added_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC69DE5E5 FOREIGN KEY (validated_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6D28840D55B127A4 ON payment (added_by_id)');
        $this->addSql('CREATE INDEX IDX_6D28840DC69DE5E5 ON payment (validated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D55B127A4');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840DC69DE5E5');
        $this->addSql('DROP INDEX IDX_6D28840D55B127A4');
        $this->addSql('DROP INDEX IDX_6D28840DC69DE5E5');
        $this->addSql('ALTER TABLE payment DROP added_by_id');
        $this->addSql('ALTER TABLE payment DROP validated_by_id');
    }
}
