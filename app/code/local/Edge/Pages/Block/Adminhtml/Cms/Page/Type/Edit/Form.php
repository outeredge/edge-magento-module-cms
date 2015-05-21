<?php

class Edge_Pages_Block_Adminhtml_Cms_Page_Type_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        /** @var $model Edge_Pages_Model_Page */
        $model = Mage::registry('pages');
        $form = new Varien_Data_Form(array(
            'id'      => 'edit_form',
            'action'  => $this->getData('action'),
            'method'  => 'post',
            'enctype' => 'multipart/form-data'
        ));
        $form->setUseContainer(true);
        $form->setHtmlIdPrefix('pagetype_');
        $fieldset = $form->addFieldset('content_fieldset', array(
            'legend' => Mage::helper('cms')->__('Content'),
            'class'  => 'fieldset-wide'
        ));
        
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }
        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('pages')->__('Title'),
            'name'  => 'name'
        ));

        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }
}
