<?php

class Edge_Pages_Block_Widget_Vimeo
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    protected function _construct()
    {
        $this->setTemplate('edge/pages/widget/vimeo.phtml');
        parent::_construct();
    }
}
