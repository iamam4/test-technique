<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpFoundation\Response;

#[Route('/api/categories')]
final class CategoryController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository)
    {
        try {
            $categories = $categoryRepository->findAll();
            return $this->json($categories, 200, [], ['groups' => 'categories.index']);
        } catch (\Exception $e) {
            return $this->json(['error' => 'An error occurred while retrieving categories'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route(path:'/{id}', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function show(Category $category)
    {
        try {
            return $this->json($category, 200, [], ['groups' => 'categories.index']);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload(serializationContext: ['groups' => ['categories.create', 'categories.index']])] Category $category, EntityManagerInterface $em)
    {
        try {
            $em->persist($category);
            $em->flush();
            return $this->json($category, Response::HTTP_CREATED, [], ['groups' => 'categories.index']);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Unable to create category'], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route(path:'/{id}', methods: ['PUT'])]
    public function update(Category $category, #[MapRequestPayload(serializationContext: ['groups' => 'categories.create'])] Category $newCategory, EntityManagerInterface $em)
    {
        try {
            $category->setName($newCategory->getName());
            $em->flush();
            return $this->json($category, 200, [], ['groups' => 'categories.index']);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Unable to update category'], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route(path:'/{id}', methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $em)
    {
        try {
            $em->remove($category);
            $em->flush();
            return $this->json(['message' => 'Category deleted successfully'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Unable to delete category, check if a product is affiliated with this category'], Response::HTTP_BAD_REQUEST);
        }
    }
}