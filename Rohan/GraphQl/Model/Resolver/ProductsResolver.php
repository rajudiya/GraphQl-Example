<?php
declare(strict_types=1);

namespace Rohan\GraphQl\Model\Resolver;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * Product collection resolver
 */
class ProductsResolver implements ResolverInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $productsData = $this->getProductsData();
        return $productsData;
    }

    /**
     * @return array
     * @throws GraphQlNoSuchEntityException
     */
    private function getProductsData(): array
    {
        try {
            /* filter for all the pages */
            $searchCriteria = $this->searchCriteriaBuilder->addFilter('entity_id', 1,'gteq')->create();
            $products = $this->productRepository->getList($searchCriteria)->getItems();
            $productRecord['allProducts'] = [];
            $counter = 1;
            foreach($products as $product) {
                $productId = $product->getId();
                $productRecord['allProducts'][$productId]['product_count'] = $counter;
                /*$productRecord['allProducts'][$productId]['sku'] = $product->getSku();
                $productRecord['allProducts'][$productId]['name'] = $product->getName();
                $productRecord['allProducts'][$productId]['price'] = $product->getPrice();*/
                $productRecord['allProducts'][$productId]['name'] = $product->getName();
                $productRecord['allProducts'][$productId]['sku'] = $product->getSku();
                $productRecord['allProducts'][$productId]['price'] = $product->getPrice();
                $productRecord['allProducts'][$productId]['description'] = $product->getDescription();
                $productRecord['allProducts'][$productId]['short_description'] = $product->getShortDescription();
                $productRecord['allProducts'][$productId]['weight'] = $product->getWeight();
                $productRecord['allProducts'][$productId]['status'] = $product->getStatus();
                $productRecord['allProducts'][$productId]['visibility'] = $product->getVisibility();
                $productRecord['allProducts'][$productId]['tax_class'] = $product->getTaxClass();
                $productRecord['allProducts'][$productId]['quantity'] = $product->getQuantity();
                $productRecord['allProducts'][$productId]['stock_availability'] = $product->getStockAvailability();
                $productRecord['allProducts'][$productId]['categories'] = $product->getCategories();
                $productRecord['allProducts'][$productId]['attribute_set'] = $product->getAttributeSet();
                $productRecord['allProducts'][$productId]['meta_title'] = $product->getMetaTitle();
                $productRecord['allProducts'][$productId]['meta_description'] = $product->getMetaDescription();
                $productRecord['allProducts'][$productId]['url_key'] = $product->getUrlKey();
                $productRecord['allProducts'][$productId]['manufacturer'] = $product->getManufacturer();
                $productRecord['allProducts'][$productId]['country_of_manufacture'] = $product->getCountryOfManufacture();
                $productRecord['allProducts'][$productId]['customizable_options'] = $product->getCustomizableOptions();
                $productRecord['allProducts'][$productId]['ogasys_image'] = $product->getOgasysImage();
                $productRecord['allProducts'][$productId]['categories'] = $product->getCategoryIds();
                $counter++;
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $productRecord;
    }
}
