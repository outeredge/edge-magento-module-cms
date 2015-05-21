<?php

class Edge_Pages_Block_Adminhtml_Cms_Page_Type extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_cms_page_type';
        $this->_blockGroup = 'pages';
        $this->_headerText = Mage::helper('pages')->__('Page Type');
        $this->_addButtonLabel = Mage::helper('pages')->__('Add Page Type');
        parent::__construct();
    }
}
