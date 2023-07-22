<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart/add/{id}', name: 'cart_add', requirements: ["id"=>"\d+"])]
    public function add(int $id, ProductRepository $productRepository, SessionInterface $session): Response
    {
        //0: Est ce que le produit existe ?
        $product = $productRepository->find($id);
        if(!$product){
            throw $this->createNotFoundException("Le produit $id n'existe pas !");
        }
        // 1. retrouver le panier dans la session (sous forme de tableau)
        // 2. Le Deuxiéme argument est la valeur par défaut de l'attribue 
       //de la session si elle n'existe pas 
       //=>Si il n'existe pas encore, alors prendre un tableau vide
        //$session = $request->getSession();
        $cart = $session->get('cart', []);

        // 3. Voir si le produit ($id) existe dèja dans le tableau
        // 4. Si c'est le cas, simplement augmenter la quantité
        // 5. Sinon ajouter le produit avec la quantité 1
        if(array_key_exists($id, $cart)){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        // 6. Sauvegarder un attribue dans une session => 
        //Enregistrer le tableau mis à jour dans la session
        $session->set('cart', $cart);
        //$session->remove('cart');

        // 7. récupérer une valeur d'un attribue =>
        $this->addFlash('success', 'Tout s\'est bien passé !');

        return $this->redirectToRoute('product_show', [
            'category_slug' => $product->getCategory()->getSlug(),
            'slug' => $product->getSlug()
        ]);
    }
}
