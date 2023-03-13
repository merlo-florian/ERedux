<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;



class MainController extends AbstractController
{
    #[Route('/api/get/items', name: 'api_get_items', methods: ['GET'])]
    public function read(ItemRepository $ItemRepo)
    {

        return $this->json($ItemRepo->findAll(), 200 , []);
    
    }

    #[Route('/api/post/create-item', name: 'api_post_create_item', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {

        $jsonContent = $request->getContent();
        try{

        $item = $serializer->deserialize($jsonContent, Item::class, 'json');

        $em->persist($item);
        $em->flush();

        return $this->json($item, 201, []);

        }catch(NotEncodableValueException $e){
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
            
    }
}
