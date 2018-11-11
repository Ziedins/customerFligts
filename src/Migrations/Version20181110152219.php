<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181110152219 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL,
  roles VARCHAR(1024), CHECK (roles IS NULL OR JSON_VALID(roles)), password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_81398E09E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE passanger (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, passport_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, passanger_id INT NOT NULL, trip_id INT NOT NULL, INDEX IDX_97A0ADA3C148EB9F (passanger_id), INDEX IDX_97A0ADA3A5BC2E0E (trip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, where_from VARCHAR(10) NOT NULL, where_to VARCHAR(10) NOT NULL, departure DATETIME NOT NULL, arrival DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C148EB9F FOREIGN KEY (passanger_id) REFERENCES passanger (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C148EB9F');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A5BC2E0E');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE passanger');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE trip');
    }
}
