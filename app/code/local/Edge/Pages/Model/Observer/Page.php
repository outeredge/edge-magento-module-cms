<?php

class Edge_Pages_Model_Observer_Page
{
    public function pageFields($observer)
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

    public function saveImage(Varien_Event_Observer $observer)
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
    }
}
