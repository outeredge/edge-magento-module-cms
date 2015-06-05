<?php

class Edge_Pages_Model_Observer_Page
{
    public function pageTypeField(Varien_Event_Observer $observer)
    {
        $model = Mage::registry('cms_page');
        $form = $observer->getEvent()->getForm();

        $pageTypeFieldset = $form->addFieldset('pagetype_fieldset', array(
            'legend' => Mage::helper('adminhtml')->__('Page Type'),
            'class'  => 'fieldset-wide'
        ));

        $menuItems = array_merge(
            [['value' => null, 'label' => '']],
            Mage::getModel('pages/page_type')->getCollection()->toOptionArray()
        );

        $pageTypeFieldset->addField('page_type', 'select', array(
            'name' => 'page_type',
            'label' => Mage::helper('adminhtml')->__('Page Type'),
            'title' => Mage::helper('adminhtml')->__('Page Type'),
            'required'  => false,
            'values'    => $menuItems
        ));

        $form->setValues($model->getData());
    }

    public function imageField(Varien_Event_Observer $observer)
    {
        $model = Mage::registry('cms_page');
        $form = $observer->getEvent()->getForm();

        $contentFieldset = $form->getElement('content_fieldset');
        $contentFieldset->addField('image', 'image', array(
            'label' => Mage::helper('adminhtml')->__('Image'),
            'name' => 'image'
        ), 'content_heading');

        $form->setValues($model->getData());
    }

    public function saveFields(Varien_Event_Observer $observer)
    {
        $model = $observer->getEvent()->getPage();
        $request = $observer->getEvent()->getRequest();

        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            try {
                $uploader = new Varien_File_Uploader('image');
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setAllowRenameFiles(true);
                $uploader->setFilesDispersion(false);

                $dirPath  = Mage::getBaseDir('media') . DS . 'page' . DS;
                $result = $uploader->save($dirPath, $_FILES['image']['name']);
                Mage::helper('core/file_storage_database')->saveFile($dirPath . $result['file']);

            } catch (Exception $e) {
                Mage::log($e->getMessage());
            }

            $model->setImage('page/' . $result['file']);
        } else {
            $data = $request->getPost();
            if (isset($data['image']) && isset($data['image']['delete']) && $data['image']['delete'] == 1) {
                $model->setImage(false);
            } elseif (isset($data['image']) && is_array($data['image'])) {
                $model->setImage($data['image']['value']);
            }
        }

        if (empty($model->getPageType())) {
            $model->setPageType(null);
        }
    }
}
