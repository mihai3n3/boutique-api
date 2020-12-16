<?php

namespace App\Controller;

use App\Repository\UserApiRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    /** @Route("/login_check", name="auth_register", methods="POST") */
    public function getTokenUser(
        Request $request,
        UserApiRepository $userApiRepository,
        UserPasswordEncoderInterface $encoder,
        JWTTokenManagerInterface $JWTManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $user = $userApiRepository->findOneBy(['user' => $data['user']]);
        $message = 'username or password is invalid';

        if (empty($user)) {
            return new JsonResponse(['message' => $message], Response::HTTP_NOT_FOUND);
        }

        $isPasswordValid = $encoder->isPasswordValid($user, $data['password']);

        if ($isPasswordValid) {
            $token = $JWTManager->create($user);
            $user->setToken($token);
            $userApiRepository->save($user);
            return new JsonResponse(['token' => $token]);
        }

        return new JsonResponse(['message' => $message], Response::HTTP_NOT_FOUND);
    }
}