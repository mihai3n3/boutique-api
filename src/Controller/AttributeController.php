<?php

namespace App\Controller;

use App\Entity\Attribute;
use App\Repository\AttributeRepository;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/attribute") */
class AttributeController extends AbstractController
{
    /** @Route("/", name="attribute_listing", methods="GET") */
    public function index(SerializerService $serializerService, AttributeRepository $attributeRepository): JsonResponse
    {
        $attributes = $attributeRepository->findAll();
        $json = $serializerService->serialize($attributes);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /** @Route("/{id}", name="attribute_item", methods="GET") */
    public function getItem(int $id, SerializerService $serializerService, AttributeRepository $attributeRepository): JsonResponse
    {
        $attribute = $attributeRepository->find($id);
        $json = $serializerService->serialize($attribute, true);

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/{id}", name="attribute_save_item_with_id", methods="PATCH")
     * @Route("/new", name="attribute_save_item_wwhitout_id", methods="PUT")
     */
    public function saveItem(Request $request, SerializerService $serializerService): JsonResponse
    {
        $attribute = $serializerService->deserialize($request->get('attribute'), Attribute::class);
        $em = $this->getDoctrine()->getManager();
        $em->merge($attribute);
        $em->persist($attribute);
        $em->flush();
        return new JsonResponse(['message' => 'New attribute added'], Response::HTTP_CREATED, [], true);
    }
}