<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add($id): Response
    {
        dd($id);
        /*return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);*/
    }
}
