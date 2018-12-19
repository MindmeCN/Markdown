<?php

namespace Mindmecn\MarkdownBundle\Migrations\pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2018/10/09 07:30:21
 */
class Version20181009192906 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE mindmecn_markdown_display_widget_config (
                id INT AUTO_INCREMENT NOT NULL, 
                markdown_id INT DEFAULT NULL, 
                default_mode INT DEFAULT 0 NOT NULL, 
                extra LONGTEXT DEFAULT NULL COMMENT '(DC2Type:json_array)', 
                widgetInstance_id INT DEFAULT NULL, 
                UNIQUE INDEX UNIQ_760D8E12AB7B5A55 (widgetInstance_id), 
                INDEX IDX_760D8E1212662797 (markdown_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE mindmecn_markdown (
                id INT AUTO_INCREMENT NOT NULL, 
                version INT NOT NULL, 
                default_mode INT DEFAULT 0 NOT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                UNIQUE INDEX UNIQ_D7F367B3B87FAB32 (resourceNode_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE mindmecn_simple_markdown_widget_config (
                id INT AUTO_INCREMENT NOT NULL, 
                content LONGTEXT NOT NULL, 
                widgetInstance_id INT DEFAULT NULL, 
                INDEX IDX_F63AB822AB7B5A55 (widgetInstance_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE mindmecn_mknote (
                id INT AUTO_INCREMENT NOT NULL, 
                version INT NOT NULL, 
                default_mode INT DEFAULT 0 NOT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                UNIQUE INDEX UNIQ_F9C43895B87FAB32 (resourceNode_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE mindmecn_mktemplate (
                id INT AUTO_INCREMENT NOT NULL, 
                version INT NOT NULL, 
                default_mode INT DEFAULT 0 NOT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                UNIQUE INDEX UNIQ_61E9DBD5B87FAB32 (resourceNode_id), 
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
                INDEX IDX_B2C9098512662797 (markdown_id), 
                INDEX IDX_B2C90985A76ED395 (user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE mindmecn_mknote_rvmknote (
                id INT AUTO_INCREMENT NOT NULL, 
                mknote_id INT DEFAULT NULL, 
                user_id INT DEFAULT NULL, 
                version INT NOT NULL, 
                content LONGTEXT NOT NULL, 
                htmlcontent LONGTEXT NOT NULL, 
                INDEX IDX_42BB2AD57D25199B (mknote_id), 
                INDEX IDX_42BB2AD5A76ED395 (user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            CREATE TABLE mindmecn_mktemplate_rvmktemplate (
                id INT AUTO_INCREMENT NOT NULL, 
                mktemplate_id INT DEFAULT NULL, 
                user_id INT DEFAULT NULL, 
                version INT NOT NULL, 
                content LONGTEXT NOT NULL, 
                htmlcontent LONGTEXT NOT NULL, 
                INDEX IDX_CB9B1B571368AF0 (mktemplate_id), 
                INDEX IDX_CB9B1B5A76ED395 (user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown_display_widget_config 
            ADD CONSTRAINT FK_760D8E12AB7B5A55 FOREIGN KEY (widgetInstance_id) 
            REFERENCES claro_widget_instance (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown_display_widget_config 
            ADD CONSTRAINT FK_760D8E1212662797 FOREIGN KEY (markdown_id) 
            REFERENCES mindmecn_markdown (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown 
            ADD CONSTRAINT FK_D7F367B3B87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown 
            ADD CONSTRAINT FK_66D008DEB87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_simple_markdown_widget_config 
            ADD CONSTRAINT FK_F63AB822AB7B5A55 FOREIGN KEY (widgetInstance_id) 
            REFERENCES claro_widget_instance (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mknote 
            ADD CONSTRAINT FK_F9C43895B87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mktemplate 
            ADD CONSTRAINT FK_61E9DBD5B87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown_revision 
            ADD CONSTRAINT FK_B2C9098512662797 FOREIGN KEY (markdown_id) 
            REFERENCES mindmecn_markdown (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown_revision 
            ADD CONSTRAINT FK_B2C90985A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mknote_rvmknote 
            ADD CONSTRAINT FK_42BB2AD57D25199B FOREIGN KEY (mknote_id) 
            REFERENCES mindmecn_mknote (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mknote_rvmknote 
            ADD CONSTRAINT FK_42BB2AD5A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE SET NULL
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mktemplate_rvmktemplate 
            ADD CONSTRAINT FK_CB9B1B571368AF0 FOREIGN KEY (mktemplate_id) 
            REFERENCES mindmecn_mktemplate (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mktemplate_rvmktemplate 
            ADD CONSTRAINT FK_CB9B1B5A76ED395 FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE SET NULL
        ");
        
                $this->addSql("
            CREATE TABLE mindmecn_mkppt (
                id INT AUTO_INCREMENT NOT NULL, 
                version INT NOT NULL, 
                default_mode INT DEFAULT 0 NOT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                UNIQUE INDEX UNIQ_D7F367B3B87FAB3P (resourceNode_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
          
           $this->addSql("
            CREATE TABLE mindmecn_mkppt_rvmkppt (
                id INT AUTO_INCREMENT NOT NULL, 
                markdown_id INT DEFAULT NULL, 
                user_id INT DEFAULT NULL, 
                version INT NOT NULL, 
                content LONGTEXT NOT NULL, 
                htmlcontent LONGTEXT NOT NULL, 
                INDEX IDX_B2C909851266279P (markdown_id), 
                INDEX IDX_B2C90985A76ED39P (user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB
        ");
                  
       $this->addSql("
            ALTER TABLE mindmecn_mkppt 
            ADD CONSTRAINT FK_D7F367B3B87FAB3P FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mkppt 
            ADD CONSTRAINT FK_66D008DEB87FAB3P FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id) 
            ON DELETE CASCADE
        ");
         $this->addSql("
            ALTER TABLE mindmecn_mkppt_rvmkppt 
            ADD CONSTRAINT FK_B2C909851266279P FOREIGN KEY (markdown_id) 
            REFERENCES mindmecn_markdown (id) 
            ON DELETE CASCADE
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mkppt_rvmkppt 
            ADD CONSTRAINT FK_B2C90985A76ED39P FOREIGN KEY (user_id) 
            REFERENCES claro_user (id) 
            ON DELETE SET NULL
        ");    
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            ALTER TABLE mindmecn_markdown_display_widget_config 
            DROP FOREIGN KEY FK_760D8E1212662797
        ");
        $this->addSql("
            ALTER TABLE mindmecn_markdown_revision 
            DROP FOREIGN KEY FK_B2C9098512662797
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mknote_rvmknote 
            DROP FOREIGN KEY FK_42BB2AD57D25199B
        ");
        $this->addSql("
            ALTER TABLE mindmecn_mktemplate_rvmktemplate 
            DROP FOREIGN KEY FK_CB9B1B571368AF0
        ");
        $this->addSql("
            DROP TABLE mindmecn_markdown_display_widget_config
        ");
        $this->addSql("
            DROP TABLE mindmecn_markdown
        ");
        $this->addSql("
            DROP TABLE mindmecn_simple_markdown_widget_config
        ");
        $this->addSql("
            DROP TABLE mindmecn_mknote
        ");
        $this->addSql("
            DROP TABLE mindmecn_mktemplate
        ");
        $this->addSql("
            DROP TABLE mindmecn_markdown_revision
        ");
        $this->addSql("
            DROP TABLE mindmecn_mknote_rvmknote
        ");
        $this->addSql("
            DROP TABLE mindmecn_mktemplate_rvmktemplate
        ");
    }
}