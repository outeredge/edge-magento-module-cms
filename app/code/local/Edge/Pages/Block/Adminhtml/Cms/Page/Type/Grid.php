<?php
class Edge_Pages_Block_Adminhtml_Cms_Page_Type_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('pagestypeGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('pages/page_type')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('pages')->__('ID'),
            'width'     => '50',
            'index'     => 'id'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('pages')->__('Name'),
            'index'     => 'name'
        ));
        return parent::_prepareColumns();
    }
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('pagetype_id' => $row->getId()));
    }
}