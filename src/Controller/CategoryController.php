<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/category") */
class CategoryController extends AbstractController
{
    /** @Route("/", name="category_listing", methods="GET") */
    public function index(SerializerService $serializerService, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findAll();
        $json = $serializerService->serialize($category);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /** @Route("/{slug}", name="category_item_by_slug", methods="GET") */
    public function getCategory(CategoryRepository $categoryRepository, SerializerService $serializerService, string $slug = null): JsonResponse
    {
        $category = null;

        if (!empty($slug)) $category = $categoryRepository->findOneBy(['slug' => $slug]);

        $json = $serializerService->serialize($category, true);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/new", name="cateegory_save_item_whitout_slug", methods="PUT")
     * @Route("/new/{slug}", name="category_save_item_whith_slug", methods="PATCH")
     */
    public function saveItem(Request $request, SerializerService $serializerService): JsonResponse
    {
        $category = $serializerService->deserialize($request->get('category'), Category::class);
        $em = $this->getDoctrine()->getManager();

        $em->merge($category);
        $em->flush();

        return new JsonResponse(['message' => 'New Category added'], Response::HTTP_CREATED, [], true);
    }
}