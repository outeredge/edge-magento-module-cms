<?php

namespace OuterEdge\Page\Model\Page;

class DataProviderPlugin
{
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    public function afterGetData(\Magento\Cms\Model\Page\DataProvider $subject, $loadedData)
    {
        if (!empty($loadedData)) {
            foreach ($loadedData as $pageId => $pageData) {
                foreach (['primary_image', 'secondary_image', 'tertiary_image'] as $image) {
                    if (isset($pageData[$image]) && is_string($pageData[$image])) {

                        $url = $this->_storeManager->getStore()->getBaseUrl(
                            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                        ) . 'page/image/' . $pageData[$image];

                        $loadedData[$pageId][$image] = array(array(
                            'name' => $pageData[$image],
                            'url' => $url
                        ));
                    }
                }
            }
        }

        return $loadedData;
    }
}
