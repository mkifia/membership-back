<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231220235650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fee ADD discount INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD year INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD is_foreign BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD is_minor BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fee DROP discount');
        $this->addSql('ALTER TABLE "user" DROP is_foreign');
        $this->addSql('ALTER TABLE "user" DROP is_minor');
        $this->addSql('ALTER TABLE payment DROP year');
    }
}
