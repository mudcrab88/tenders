<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220901194810 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE tender_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tender (id INT NOT NULL, 
            external_code INT NOT NULL, 
            number VARCHAR(255) NOT NULL, 
            status VARCHAR(255) DEFAULT NULL, 
            name VARCHAR(255) NOT NULL, 
            change_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, 
            PRIMARY KEY(id))'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EXTERNAL_CODE ON tender (external_code)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_NUMBER ON tender (number)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE tender_id_seq CASCADE');
        $this->addSql('DROP TABLE tender');
    }
}
