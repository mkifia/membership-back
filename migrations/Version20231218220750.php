<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218220750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment ADD member_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D7597D3FE FOREIGN KEY (member_id) REFERENCES "user" (id) DEFERRABLE INITIALLY DEFERRED');
        $this->addSql('CREATE INDEX IDX_6D28840D7597D3FE ON payment (member_id)');
        $this->addSql('ALTER TABLE "user" ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD team_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) DEFERRABLE INITIALLY DEFERRED');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) DEFERRABLE INITIALLY DEFERRED');
        $this->addSql('CREATE INDEX IDX_8D93D649F5B7AF75 ON "user" (address_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649296CD8AE ON "user" (team_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649296CD8AE');
        $this->addSql('DROP INDEX IDX_8D93D649F5B7AF75');
        $this->addSql('DROP INDEX IDX_8D93D649296CD8AE');
        $this->addSql('ALTER TABLE "user" DROP address_id');
        $this->addSql('ALTER TABLE "user" DROP team_id');
        $this->addSql('ALTER TABLE payment DROP CONSTRAINT FK_6D28840D7597D3FE');
        $this->addSql('DROP INDEX IDX_6D28840D7597D3FE');
        $this->addSql('ALTER TABLE payment DROP member_id');
    }
}
