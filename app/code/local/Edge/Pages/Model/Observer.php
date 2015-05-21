<?php

class Edge_Pages_Model_Observer
{
    public function cmsField($observer)
    {
        $form = $observer->getForm();
        $fieldset = $form->addFieldset('pagetype_fieldset', array(
            'legend' => Mage::helper('adminhtml')->__('Page Type'),
            'class'  => 'fieldset-wide'
        ));

        $menuItems = array_merge(
            [['value' => NULL,'label' => '']],
            Mage::getModel('pages/page_type')->getCollection()->toOptionArray()
        );

        $fieldset->addField('page_type', 'select', array(
            'name' => 'page_type',
            'label' => Mage::helper('adminhtml')->__('Page Type'),
            'title' => Mage::helper('adminhtml')->__('Page Type'),
            'required'  => false,
            'values'    => $menuItems,
        ));
    }

    public function saveEditField($observer)
    {
        $modelPage = $observer->getEvent()->getPage();

        if (empty($modelPage->getPageType())) {
            $modelPage->setPageType(NULL);
        }
    }
}
