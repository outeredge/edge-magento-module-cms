<?php

$this->startSetup();

// Promotion
$this->run("
    CREATE TABLE IF NOT EXISTS {$this->getTable('pages/page_type')} (
            `id` int( 11 ) unsigned NOT NULL AUTO_INCREMENT ,
            `name` varchar( 255 ) NOT NULL default '',
            PRIMARY KEY ( `id` ) ,
            UNIQUE KEY `name` ( `name` )
        ) ENGINE = InnoDB DEFAULT CHARSET = utf8;

    ALTER TABLE {$this->getTable('cms_page')}
        ADD `page_type` INT(11) unsigned NULL DEFAULT NULL;

    ALTER TABLE {$this->getTable('cms_page')}
    ADD CONSTRAINT `fk_page_type`
    FOREIGN KEY (`page_type`)
    REFERENCES `cms_page_type` (`id`)
    ON DELETE SET NULL;
");

$this->endSetup();