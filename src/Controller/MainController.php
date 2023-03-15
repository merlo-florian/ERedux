<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\CartItemRepository;
use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class MainController extends AbstractController
{
    #[Route('/api/get/items', name: 'api_get_items', methods: ['GET'])]
    public function readItems(ItemRepository $ItemRepo)
    {

        return $this->json($ItemRepo->findAll(), 200 , []);
    
    }

    #[Route('/api/get/items_by_cart_id/{id}', name: 'api_get_items_by_cart_id', methods: ['GET'])]
    public function readItemsByCartId(int $id, CartItemRepository $CartItemRepo)
    {

        return $this->json($CartItemRepo->findBy(array('cart_id' => $id)));
    
    }

    #[Route('/api/get/user_by_email/{name}/{domain}/{ext}', name: 'api_get_user_by_email', methods: ['GET'])]
    public function readUserByEmail(string $name, $domain, $ext, UserRepository $UserRepo)
    {

        $email = $name . "@" . $domain . "." . $ext;
    
        return $this->json($UserRepo->findBy(array('email' => $email)));

    }

    #[Route('/api/post/create-item', name: 'api_post_create_item', methods: ['POST'])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $validator)
    {

        $jsonContent = $request->getContent();
        try{

        $item = $serializer->deserialize($jsonContent, Item::class, 'json');

        $errors = $validator->validate($item);

        if(count($errors) > 0){
            return $this->json($errors, 400);
        }

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
