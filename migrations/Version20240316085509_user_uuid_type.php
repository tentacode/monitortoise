<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240316085509_user_uuid_type extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changing user.uuid type to match Symfony UUID type.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE "user" ALTER uuid TYPE UUID');
        $this->addSql('COMMENT ON COLUMN "user".uuid IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER INDEX unique_uuid RENAME TO UNIQ_8D93D649D17F50A6');
        $this->addSql('ALTER INDEX unique_email RENAME TO UNIQ_8D93D649E7927C74');
        $this->addSql('ALTER INDEX unique_username RENAME TO UNIQ_8D93D649F85E0677');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ALTER uuid TYPE UUID');
        $this->addSql('COMMENT ON COLUMN "user".uuid IS NULL');
        $this->addSql('ALTER INDEX uniq_8d93d649f85e0677 RENAME TO unique_username');
        $this->addSql('ALTER INDEX uniq_8d93d649e7927c74 RENAME TO unique_email');
        $this->addSql('ALTER INDEX uniq_8d93d649d17f50a6 RENAME TO unique_uuid');
    }
}
