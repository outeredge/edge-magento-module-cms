<?php

class Edge_Pages_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getPagesByType($name)
    {
        $pageType = Mage::getModel('pages/page_type')->load($name, 'name');

        return Mage::getModel('cms/page')
            ->getCollection()
            ->addFieldToFilter('page_type', array('eq' => $pageType->getId()));
    }
}
