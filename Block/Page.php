<?php

namespace OuterEdge\Page\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Cms\Model\Page as CmsPage;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Exception\LocalizedException;

class Page extends Template implements IdentityInterface
{
    /**
     * @var FilterProvider
     */
    protected $_filterProvider;

    /**
     * @var CmsPage
     */
    protected $_page;

    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @param Context $context
     * @param CmsPage $page
     * @param FilterProvider $filterProvider
     * @param PageFactory $pageFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        CmsPage $page,
        FilterProvider $filterProvider,
        PageFactory $pageFactory,
        array $data = []
    ) {
        $this->_page = $page;
        $this->_filterProvider = $filterProvider;
        $this->_pageFactory = $pageFactory;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve Page instance
     *
     * @return CmsPage
     */
    public function getPage()
    {
        if (!$this->hasData('page')) {
            if ($this->getPageId()) {
                /** @var \Magento\Cms\Model\Page $page */
                $page = $this->_pageFactory->create();
                $page->setStoreId($this->_storeManager->getStore()->getId())->load($this->getPageId(), 'identifier');
            } else {
                $page = $this->_page;
            }
            $this->setData('page', $page);
        }
        return $this->getData('page');
    }

    /**
     * Prepare global layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $page = $this->getPage();
        $this->_addBreadcrumbs($page);
        $this->pageConfig->addBodyClass('cms-' . $page->getIdentifier());
        $metaTitle = $page->getMetaTitle();
        $this->pageConfig->getTitle()->set($metaTitle ? $metaTitle : $page->getTitle());
        $this->pageConfig->setKeywords($page->getMetaKeywords());
        $this->pageConfig->setDescription($page->getMetaDescription());

        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            // Setting empty page title if content heading is absent
            $cmsTitle = $page->getContentHeading() ?: ' ';
            $pageMainTitle->setPageTitle($this->escapeHtml($cmsTitle));
        }
        return parent::_prepareLayout();
    }

    /**
     * Prepare breadcrumbs
     *
     * @param CmsPage $page
     * @throws LocalizedException
     * @return void
     */
    protected function _addBreadcrumbs(CmsPage $page)
    {
        if ($this->_scopeConfig->getValue('web/default/show_cms_breadcrumbs', ScopeInterface::SCOPE_STORE)
            && ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs'))
            && $page->getIdentifier() !== $this->_scopeConfig->getValue(
                'web/default/cms_home_page',
                ScopeInterface::SCOPE_STORE
            )
            && $page->getIdentifier() !== $this->_scopeConfig->getValue(
                'web/default/cms_no_route',
                ScopeInterface::SCOPE_STORE
            )
        ) {
            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'),
                    'title' => __('Go to Home Page'),
                    'link' => $this->_storeManager->getStore()->getBaseUrl()
                ]
            );
            $breadcrumbsBlock->addCrumb('cms_page', ['label' => $page->getTitle(), 'title' => $page->getTitle()]);
        }
    }

    public function getContent()
    {
        return $this->_filterProvider->getPageFilter()->filter($this->getPage()->getContent());
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [Page::CACHE_TAG . '_' . $this->getPage()->getId()];
    }
}
