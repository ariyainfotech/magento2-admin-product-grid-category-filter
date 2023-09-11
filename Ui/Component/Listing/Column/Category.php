<?php
/**
 * Copyright © Ariya InfoTech(Yuvraj Raulji) All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AriyaInfoTech\AdminProductGridCategoryFilter\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Category extends Column
{
    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getData('name');

        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $productId = $item['entity_id'];

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $product = $objectManager->create('Magento\Catalog\Model\Product')->load($productId);

                $categoryIds = $product->getCategoryIds();
                $categories = array();
                
                if (count($categoryIds)) {
                    foreach ($categoryIds as $categoryId) {
                        $category = $objectManager->create('Magento\Catalog\Model\Category')->load($categoryId);
                        $categories[] = $category->getName();
                    }
                }
                $item[$fieldName] = implode(',', $categories);
            }
        }

        return $dataSource;
    }
}