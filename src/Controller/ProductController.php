<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;



#[Route('/api/products')]
final class ProductController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();
        return $this->json(
            $products,
            200,
            [],
            ['groups' => 'products.index']
        );
    }


    #[Route('/{id}', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function show(Product $product)
    {
        return $this->json(
            $product,
            200,
            [],
            ['groups' => ['products.index', 'products.show']]
        );
    }

    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload(serializationContext: ['groups' => 'products.create'])] Product $product, EntityManagerInterface $em)
    {
        $product->setCreateAt(new \DateTimeImmutable());
        $em->persist($product);
        $em->flush();
        return $this->json(
            $product,
            200,
            [],
            ['groups' => ['products.index', 'products.show']]
        );
    }


    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Product $product,
        #[MapRequestPayload(serializationContext: ['groups' => 'products.update'])] Product $newProduct,
        EntityManagerInterface $em,
        CategoryRepository $categoryRepository
    ) {
        // Update basic product info
        $product->setName($newProduct->getName());
        $product->setDescription($newProduct->getDescription());
        $product->setPrice($newProduct->getPrice());
    
        // Handle category
        if ($newProduct->getCategory()) {
            $existingCategory = $categoryRepository->findOneBy(['name' => $newProduct->getCategory()->getName()]);
            if ($existingCategory) {
                $product->setCategory($existingCategory);
            } else {
                $product->setCategory($newProduct->getCategory());
                $em->persist($newProduct->getCategory());
            }
        } else {
            $product->setCategory(null);
        }
    
        $em->flush();
        
        return $this->json(
            $product,
            200,
            [],
            ['groups' => ['products.index', 'products.show']]
        );
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Product $product, EntityManagerInterface $em)
    {
        $em->remove($product);
        $em->flush();
        return $this->json(['message' => 'Product deleted'], 200);
    }
}

