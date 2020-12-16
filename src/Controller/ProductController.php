<?php


namespace App\Controller;

use App\Manager\ElasticAppSearchManager;
use App\Repository\ProductRepository;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/product") */
class ProductController extends AbstractController
{
    /** @Route("/", name="product_listing", methods="GET") */
    public function index(SerializerService $serializerService, ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();
        $json = $serializerService->serialize($products);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /** @Route("/{id}", name="product_item_details", methods="GET") */
    public function getProduct(int $id, SerializerService $serializerService, ProductRepository $productRepository): JsonResponse
    {
        $product = $productRepository->find($id);
        $json = $serializerService->serialize($product, true);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /** @Route("/{id}", name="product_item_update", methods="PATCH") */
    public function saveItem(int $id, ProductRepository $productRepository, ElasticAppSearchManager $elasticAppSearchManager)
    {
        /** @TODO add new item ^_^ */
        $product = $productRepository->find($id);

        $elasticAppSearchManager->indexProductDocuments($product);
    }
}