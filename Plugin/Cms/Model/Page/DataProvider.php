<?php

namespace OuterEdge\Page\Plugin\Cms\Model\Page;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Cms\Model\Page\DataProvider as PageDataProvider;
use Magento\Framework\UrlInterface;

class DataProvider
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        StoreManagerInterface $storeManager
    ) {
        $this->_storeManager = $storeManager;
    }

    public function afterGetData(PageDataProvider $subject, $loadedData)
    {
        if (!empty($loadedData)) {
            foreach ($loadedData as $pageId => $pageData) {
                foreach (['primary_image', 'secondary_image', 'tertiary_image'] as $image) {
                    if (isset($pageData[$image]) && is_string($pageData[$image])) {
                        $url = $this->_storeManager->getStore()->getBaseUrl(
                            UrlInterface::URL_TYPE_MEDIA
                        ) . 'page/image/' . $pageData[$image];

                        $loadedData[$pageId][$image] = [[
                            'name' => $pageData[$image],
                            'url' => $url
                        ]];
                    }
                }
            }
        }

        return $loadedData;
    }
}
