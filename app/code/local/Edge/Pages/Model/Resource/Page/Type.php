<?php

class Edge_Pages_Model_Resource_Page_Type extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('pages/page_type', 'id');
    }
}
