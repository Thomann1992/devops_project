<?php

namespace App\Controller;

// ...
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Description;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UpdateController extends AbstractController
{
    #[Route('/update', name: '')]
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $getAll = $doctrine->getRepository(Description::class)->findAll();
            
            
        foreach ($getAll as $description){
            $description->setLatestCommitDate();            
        }
        $entityManager->flush();
        $this->addFlash('updated', 'All descriptions has been updated');
        
        return $this->redirectToRoute('admin');
        // return new Response('Descriptions got updated');
        
    }
    

        

        
}

