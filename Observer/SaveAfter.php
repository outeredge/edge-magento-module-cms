<?php

namespace OuterEdge\Page\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveAfter implements ObserverInterface
{
    /**
     * Image uploader
     *
     * @var \Magento\Catalog\Model\ImageUploader
     */
    private $imageUploader;

    /**
     * Moving page images from tmp folder
     * Saving images which haven't changed
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $page = $observer->getEvent()->getDataObject();

        foreach (['primary_image', 'secondary_image', 'tertiary_image'] as $imageName) {
            $image = $page->getData($imageName);
            $imageIsNew = $page->getData('upload/' . $imageName);
            if (null !== $image && $imageIsNew) {
                try {
                    $this->getImageUploader()->moveFileFromTmp($image);
                } catch (Exception $e) {
                    $this->_logger->critical($e);
                }
            }
        }

        return $this;
    }

    private function getImageUploader()
    {
        if (null === $this->imageUploader) {
            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get('OuterEdge\Page\ImageUpload');
        }
        return $this->imageUploader;
    }
}
