<?php

namespace App\Manager;

use App\Entity\Attribute;
use App\Entity\AttributeTemplateSection;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductAttribute;
use App\Service\RedisService;
use Elastic\AppSearch\Client\Client;
use Elastic\AppSearch\Client\ClientBuilder;
use Exception;

class ElasticAppSearchManager
{
    public const ELASTIC_SEARCH_FACET_CATEGORY = 'ELASTIC_SEARCH_FACET_CATEGORY_';

    /** @var Client */
    public $client;
    /** @var string */
    private $engine;
    /** @var RedisService */
    private $cache;

    public function __construct($apiEndpoint, $apiKey, $engine, RedisService $cache)
    {
        $clientBuilder = ClientBuilder::create($apiEndpoint, $apiKey);

        $this->client = $clientBuilder->build();
        $this->engine = $engine;
        $this->cache = $cache;
    }

    public function search(string $key, Category $category, array $filters = null): array
    {
        $searchParams = $this->computeFacetsStructure($category);

        return $this->client->search($this->engine, $key, $searchParams);
    }

    private function computeFacetsStructure(Category $category, bool $resetCache = false): array
    {
        $parent = $category;
        if (!empty($category->getParent())) {
            $parent = $category->getParent();
            if (!empty($parent->getParent())) {
                $parent = $parent->getParent();
            }
        }

        $cacheKey = self::ELASTIC_SEARCH_FACET_CATEGORY . $parent->getId();

        if ($resetCache) $this->cache->removeItem($cacheKey);
        $searchParams = $this->cache->getItem($cacheKey);

        if ($searchParams !== null) return $searchParams;

        try {
            $searchParams['facets']['brand'] = ['type' => 'value', 'size' => 100, 'sort' => ['count' => 'desc']];
            /** @var AttributeTemplateSection $section */
            foreach ($parent->getAttributeTemplate()->getSection() as $section) {

                /** @var Attribute $attribute */
                foreach ($section->getAttribute() as $attribute) {
                    if (!$attribute->getUseAsFilter()) continue;
                    $searchParams['facets'][strtolower(str_replace(' ', '_', $attribute->getName()))] =
                        [
                            'type' => 'value',
                            'size' => 100,
                            'sort' => ['count' => 'desc'],
                        ];

                }
            }
            $this->cache->saveItem($cacheKey, $searchParams, 3600);
        } catch (Exception $e) {
            //@ToDo log information
        }

        return $searchParams;
    }

    public function indexProductDocuments(Product $product): array
    {
        $data = $this->computeProductDocumentStructure($product);
        $response = $this->client->indexDocuments($this->engine, $data);

        return $response;
    }

    private function computeProductDocumentStructure(Product $product): array
    {
        $data = [
            'id' => $product->getId(),
            'product_id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'category' => $product->getCategory()->getName(),
            'brand' => $product->getBrand()->getName(),
        ];

        /** @var ProductAttribute $attribute */
        foreach ($product->getProductAttributes() as $attribute) {
            $key = strtolower(str_replace(' ', '_', $attribute->getAttribute()->getName()));
            $value = json_decode($attribute->getValue());
            if (!is_array($value)) {
                $data[$key] = $value;
            } else {
                foreach ($value as $k => $item) {
                    $key = $key . '_' . $k;
                    $data[$key] = $item;
                }
            }
        }

        return $data;
    }
}