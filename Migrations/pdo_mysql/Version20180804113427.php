<?php

namespace Mindme\MarkdownBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2018/08/04 11:34:30
 */
class Version20180804113427 extends AbstractMigration
{
    public function up(Schema $schema)
    {    
        $this->addSql("
            CREATE TABLE mindmecn_markdown (
                id INT AUTO_INCREMENT NOT NULL, 
                version INT NOT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                UNIQUE INDEX UNIQ_66D008DEB87FAB32 (resourceNode_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE mindmecn_markdown_revision (
                id INT AUTO_INCREMENT NOT NULL, 
                markdown_id INT DEFAULT NULL, 
                user_id INT DEFAULT NULL, 
                version INT NOT NULL, 
                content LONGTEXT NOT NULL, 
                htmlcontent LONGTEXT NOT NULL, 
                INDEX IDX_39ED3EB012662797 (markdown_id), 
                INDEX IDX_39ED3EB0A76ED395 (user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown 
            ADD CONSTRAINT FK_66D008DEB87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown_revision 
            ADD CONSTRAINT FK_39ED3EB012662797 FOREIGN KEY (markdown_id) 
            REFERENCES mindme_markdown (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown_revision 
            ADD CONSTRAINT FK_39ED3EB0A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE SET NULL
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE mindmecn_markdown_revision 
            DROP FOREIGN KEY FK_39ED3EB012662797
        ");
        $this->addSql("
            DROP TABLE mindmecn_markdown
        ");
        $this->addSql("
            DROP TABLE mindmecn_markdown_revision
        ");
    }
}