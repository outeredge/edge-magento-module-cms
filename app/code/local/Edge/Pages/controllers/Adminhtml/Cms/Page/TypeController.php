<?php

class Edge_Pages_Adminhtml_Cms_Page_TypeController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_title($this->__('outer/edge'))
            ->_title($this->__('PageType'))
            ->_setActiveMenu('edge');
        return $this;
    }

    public function indexAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('PageType'))
             ->_title($this->__('Types'))
             ->_title($this->__('Manage Content'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('pagetype_id');
        $model = Mage::getModel('pages/page_type');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('pages')->__('This pagetype no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Slide'));

        // 3. Set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        Mage::register('pages', $model);

        // 5. Build edit form
        $this->_initAction()
             ->_addBreadcrumb(
                $id ? Mage::helper('pages')->__('Edit Pagetype')
                    : Mage::helper('pages')->__('New Pagetype'),
                $id ? Mage::helper('pages')->__('Edit Pagetype')
                    : Mage::helper('pages')->__('New Pagetype'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {

            //init model and set data
            $model = Mage::getModel('pages/page_type');
            $model->setData($data);

            // try to save it
            try {
                // save the data
                $model->save();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('pages')->__('The page type has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('pagetype_id' => $model->getId()));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('pages')->__('An error occurred while saving the page type.'));
            }
            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('pagetype_id' => $this->getRequest()->getParam('pagetype_id')));
            return;
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('pagetype_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('pages/page_type');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('pages')->__('The page type has been deleted.'));
                // go to grid
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('pagetype_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pages')->__('Unable to find a page type to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }
}
