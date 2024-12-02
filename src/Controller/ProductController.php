<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
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

    public function update(Product $product, #[MapRequestPayload(serializationContext: ['groups' => 'products.update'])] Product $newProduct, EntityManagerInterface $em)
    {
        $product->setName($newProduct->getName());
        $product->setDescription($newProduct->getDescription());
        $product->setPrice($newProduct->getPrice());
        $product->setCategory($newProduct->getCategory());
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

