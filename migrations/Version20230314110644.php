<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314110644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('ALTER TABLE cart DROP INDEX FK_UserCart, ADD UNIQUE INDEX UNIQ_BA388B7A76ED395 (user_id)');
        $this->addSql('ALTER TABLE user DROP cart');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_item (cart_id INT NOT NULL, item_id INT NOT NULL, price INT NOT NULL, qty INT NOT NULL, INDEX FK_join_itemid (item_id), PRIMARY KEY(cart_id, item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cart DROP INDEX UNIQ_BA388B7A76ED395, ADD INDEX FK_UserCart (user_id)');
        $this->addSql('ALTER TABLE cart DROP FOREIGN KEY FK_BA388B7A76ED395');
        $this->addSql('ALTER TABLE user ADD cart VARCHAR(255) NOT NULL');
    }
}
