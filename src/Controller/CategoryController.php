<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/categories')]
final class CategoryController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index( CategoryRepository $categoryRepository){
        $categories = $categoryRepository->findAll();
        return $this->json($categories, 200, [],
         ['groups' => 'categories.index']);
    }


}

//     #[Route('', methods: ['POST'])]
//     public function new(
//         Request $request,
//         EntityManagerInterface $entityManager,
//         SerializerInterface $serializer,
//         ValidatorInterface $validator
//     ): JsonResponse {
//         try {
//             $category = $serializer->deserialize($request->getContent(), Category::class, 'json');

//             $errors = $validator->validate($category);
//             if (count($errors) > 0) {
//                 return $this->json($errors, Response::HTTP_BAD_REQUEST);
//             }

//             $entityManager->persist($category);
//             $entityManager->flush();

//             return new JsonResponse(
//                 $serializer->serialize($category, 'json'),
//                 Response::HTTP_CREATED,
//                 [],
//                 true
//             );
//         } catch (\Exception $e) {
//             return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
//         }
//     }

//     #[Route('/{id}', methods: ['GET'])]
//     public function show(
//         Category $category,
//         SerializerInterface $serializer
//     ): JsonResponse {
//         return new JsonResponse(
//             $serializer->serialize($category, 'json'),
//             Response::HTTP_OK,
//             [],
//             true
//         );
//     }

//     #[Route('/{id}', methods: ['PUT'])]
//     public function edit(
//         Request $request,
//         Category $category,
//         EntityManagerInterface $entityManager,
//         SerializerInterface $serializer,
//         ValidatorInterface $validator
//     ): JsonResponse {
//         try {
//             $updatedCategory = $serializer->deserialize(
//                 $request->getContent(),
//                 Category::class,
//                 'json'
//             );

//             $category->setName($updatedCategory->getName());

//             $errors = $validator->validate($category);
//             if (count($errors) > 0) {
//                 return $this->json($errors, Response::HTTP_BAD_REQUEST);
//             }

//             $entityManager->flush();

//             return new JsonResponse(
//                 $serializer->serialize($category, 'json'),
//                 Response::HTTP_OK,
//                 [],
//                 true
//             );
//         } catch (\Exception $e) {
//             return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
//         }
//     }

//     #[Route('/{id}', methods: ['DELETE'])]
//     public function delete(
//         Category $category,
//         EntityManagerInterface $entityManager
//     ): JsonResponse {
//         try {
//             $entityManager->remove($category);
//             $entityManager->flush();

//             return new JsonResponse(null, Response::HTTP_NO_CONTENT);
//         } catch (\Exception $e) {
//             return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
//         }
//     }
// }