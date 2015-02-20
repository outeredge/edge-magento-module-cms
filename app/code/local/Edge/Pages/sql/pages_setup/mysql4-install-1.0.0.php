<?php

$this->startSetup();

$db = $this->getConnection();
$table = $this->getTable('cms_page');

$db->addColumn($table, 'image', 'text');

$this->endSetup();