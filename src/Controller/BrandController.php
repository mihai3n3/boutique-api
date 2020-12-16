<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Repository\BrandRepository;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/brand") */
class BrandController extends AbstractController
{
    /** @Route("/", name="brand_listing", methods="GET") */
    public function index(SerializerService $serializerService, BrandRepository $brandRepository): JsonResponse
    {
        $brands = $brandRepository->findAll();
        $json = $serializerService->serialize($brands);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /** @Route("/{id}", name="brand_item", methods="GET") */
    public function getBrand(int $id, SerializerService $serializerService, BrandRepository $brandRepository): JsonResponse
    {
        $brand = $brandRepository->find($id);
        $json = $serializerService->serialize($brand);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/new", name="brand_save_item", methods="PUT")
     * @Route("/new/{id}", name="brand_save_item_with_id", methods="PATCH")
     */
    public function saveItem(Request $request, SerializerService $serializerService): JsonResponse
    {
        $attribute = $serializerService->deserialize($request->get('brand'), Brand::class);
        $em = $this->getDoctrine()->getManager();

        $em->merge($attribute);
        $em->flush();

        return new JsonResponse(['message' => 'New Brand added'], Response::HTTP_CREATED);
    }
}