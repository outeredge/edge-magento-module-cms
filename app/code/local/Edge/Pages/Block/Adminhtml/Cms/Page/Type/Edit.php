<?php
class Edge_Pages_Block_Adminhtml_Cms_Page_Type_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Initialize slideshow edit block
     * @return void
     */
    public function __construct()
    {
        $this->_objectId   = 'pagetype_id';
        $this->_controller = 'adminhtml_cms_page_type';
        $this->_blockGroup = 'pages';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('pages')->__('Save Page Type'));
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        $this->_updateButton('delete', 'label', Mage::helper('pages')->__('Delete Page Type'));
        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    /**
     * Retrieve text for header element depending on loaded page
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('pages')->getId()) {
            return Mage::helper('pages')->__("Edit Page Type '%s'", $this->escapeHtml(Mage::registry('pages')->getTitle()));
        }
        else {
            return Mage::helper('pages')->__('New Page Type');
        }
    }
    /**
     * Get form action URL
     * @return string
     */
    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }
        return $this->getUrl('*/*/save');
    }
}