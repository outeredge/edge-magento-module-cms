<?php

class Edge_Pages_Block_Widget_Youtube
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    protected function _construct()
    {
        $this->setTemplate('edge/pages/widget/youtube.phtml');
        parent::_construct();
    }
}
