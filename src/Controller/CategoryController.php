<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
#[Route('/api/categories')]
final class CategoryController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index( CategoryRepository $categoryRepository){
        $categories = $categoryRepository->findAll();
        return $this->json($categories, 200, [],
         ['groups' => 'categories.index']
        );
    }

    #[Route(path:'/{id}', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function show(Category $category){
        return $this->json($category, 200, [], ['groups' => 'categories.index']);
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload(serializationContext: ['groups' => ['categories.create', 'categories.index']])] Category $category, EntityManagerInterface $em)
    {
        $em->persist($category);
        $em->flush();
        return $this->json(
            $category,
            200,
            [],
            ['groups' => 'categories.index']

        );
    }

    #[Route(path:'/{id}', methods: ['PUT'])]
    public function update(Category $category, #[MapRequestPayload(serializationContext: ['groups' => 'categories.create'])] Category $newCategory, EntityManagerInterface $em)
    {
        $category->setName($newCategory->getName());
        $em->flush();
        return $this->json($category, 200, [], ['groups' => 'categories.index']);
    }

    #[Route(path:'/{id}', methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $em)
    {
        $em->remove($category);
        $em->flush();
        return $this->json(['message' => 'Category deleted'], 200);
    }


}