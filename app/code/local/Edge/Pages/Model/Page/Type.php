<?php

class Edge_Pages_Model_Page_Type extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('pages/page_type');
    }
}
