<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Truc;
use App\Repository\CategoryRepository;
use App\Repository\TrucRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class MachinController extends AbstractController
{
    #[Route('/trucs', name: 'app_machins')]
    public function index(TrucRepository $repository): Response
    {
        $trucs = $repository->findAll();

        return $this->json($trucs, 200, [], ['groups' => ['read-trucs']]);
    }

    #[Route('/truc/{id}', name: 'app_machin', methods: ['GET'])]
    public function show(Truc $truc): Response
    {

        return $this->json($truc, 200, [], ['groups' => ['read-truc']]);
    }
     #[Route('/truc/new/{idCategory}', name: 'app_machin', methods: [ 'POST'])]
public function new(CategoryRepository $categoryRepository,
                    $idCategory,
                    EntityManagerInterface $manager,
                    SerializerInterface $serializer,
                    Request $request): Response
     {
        $category = $categoryRepository->find($idCategory);


        if(!$category){
            return $this->json("non-existent category", 403);
        }

        $truc = $serializer->deserialize($request->getContent(),
            Truc::class,
            'json');


        $truc->setCategory($category);
         $manager->persist($truc);
         $manager->flush();
         return $this->json($truc, 200, [], ['groups' => ['read-truc']]);
     }
}
