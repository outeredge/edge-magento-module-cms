<?php

class Edge_Pages_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getPageByType($name)
    {
        $pageType = Mage::getModel('pages/page_type')->load($name, 'name');

        if (empty($pageType->getData())) {
            return "Page Type don't exist.";
        }

        $result = Mage::getModel('cms/page')
            ->getCollection()
            ->addFieldToFilter('page_type', array('eq' => $pageType->getId()));

        if (empty($result->getData())) {
            return "No cms page with that type.";
        }

        return $result;
    }
}
