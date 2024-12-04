<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;


#[Route('/api/users')]
final class UserController extends AbstractController {


    #[Route('', methods: ['GET'])]
    public function index(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->json(
            $users,
            200,
            [],
            ['groups' => 'users.index']
        );
    }



    #[Route('/{id}', methods: ['GET'], requirements: ['id' => Requirement::DIGITS])]
    public function show(User $user)
    {
        return $this->json(
            $user,
            200,
            [],
            ['groups' => ['users.index', 'users.show']]
        );
    }


    #[Route('', methods: ['POST'])]
    public function create(#[MapRequestPayload(serializationContext: ['groups' => 'users.create'])] User $user, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        );

        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();
        return $this->json(
            $user,
            200,
            [],
            ['groups' => ['users.index', 'users.show']]
        );
    }


    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        User $user,
        #[MapRequestPayload(serializationContext: ['groups' => 'users.update'])] User $newUser,
        EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher
    )
    {
        $user->setEmail($newUser->getEmail());
        
        if ($newUser->getPassword()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $newUser->getPassword()
            );
            $user->setPassword($hashedPassword);
        }

        $em->flush();
        return $this->json(
            $user,
            200,
            [],
            ['groups' => ['users.index', 'users.show']]
        );
    }


    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(User $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        $em->flush();
        return $this->json(['message' => 'Product deleted'], 200);
    }

}
