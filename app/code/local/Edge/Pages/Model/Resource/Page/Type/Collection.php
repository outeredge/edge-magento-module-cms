<?php

class Edge_Pages_Model_Resource_Page_Type_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('pages/page_type');
    }
}
