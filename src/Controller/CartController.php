<?php

namespace App\Controller;

use App\Cart\CartService;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CartController extends AbstractController
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var CartService
     */
    protected $cartService;

    public function __construct(ProductRepository $productReporitory, CartService $cartService){
        $this->productRepository = $productReporitory;
        $this->cartService = $cartService;
    }

    /**
     * Add quantity to product if we add products into the basket
     */
    #[Route('/cart/add/{id}', name: 'cart_add', requirements: ["id"=>"\d+"])]
    public function add(int $id, Request $request): Response
    {
        $session = $request->getSession();

        //0: Est ce que le produit existe en bdd avec l'id correspondant ?
        $product = $this->productRepository->find($id);

        //Si le produit n'existe pas avec l'id correspondant , alors je lance une exception
        if(!$product){
            throw $this->createNotFoundException("Le produit $id n'existe pas !");
        }

        //J'ajoute l'id et la session au sein du cartService, 
        //qui me permet d'incrémenter ou pas les quantités de produits 
        //à ajouter un produit en session
        $this->cartService->add($id, $session);

        // 7. récupérer une valeur d'un attribue =>
        //J'ajoute un message flash lorsque le produit a bien été ajouté au panier
        $this->addFlash('success', 'Le produit a bien été ajouté au panier !');

        if($request->query->get('returnToCart')){
            return $this->redirectToRoute('cart_show');
        }
        //Je fais une redirection vers la fiche du produit
        return $this->redirectToRoute('product_show', [
            'category_slug' => $product->getCategory()->getSlug(),
            'slug' => $product->getSlug()
        ]);
    }

    /**
     * Show the basket with total, products name and quantity
     */
    #[Route('/cart', name: 'cart_show')]
    public function show(Request $request): Response {
        
        $session = $request->getSession();

        //Il demande au cart service quels produits on a et comme détails
        $detailedCart = $this->cartService->getDetailedCartItems($session);

        //Il demande au cart service quel total on a 
        $total = $this->cartService->getTotal($session);

        //On envoi tout ca au panier. Tableau dans lequel il y a un tableau
        return $this->render('cart/index.html.twig', [
            'items' => $detailedCart,
            'total' => $total
        ]);
    }

    /**
     * Remove the products from the basket
     */
    #[Route('/cart/delete/{id}', name: 'cart_delete', requirements: ["id"=>"\d+"])]
    public function delete(int $id, Request $request): Response {
        
        $session = $request->getSession();

        $product = $this->productRepository->find($id);

        if(!$product){
            throw $this->createNotFoundException("Le produit $id n'existe pas et ne peut pas étre supprimé");
        }

        $this->cartService->remove($id, $session);

        $this->addFlash('success', 'Le produit a bien été supprimé du panier !');

        return $this->redirectToRoute("cart_show");
    }

    /**
     * Decrements quantity into the basket
     */
    #[Route('/cart/decrement/{id}', name: 'cart_decrement', requirements: ["id"=>"\d+"])]
    public function decrement(Request $request, int $id): Response {
        
        $session = $request->getSession();

        $product = $this->productRepository->find($id);

        if(!$product){
            throw $this->createNotFoundException("Le produit $id n'existe pas et ne peut pas étre décrémenté");
        }
        $this->cartService->decrement($id, $session);

        $this->addFlash('success', 'Le produit a bien été décrémenté !');        
    
        return $this->redirectToRoute("cart_show");
    }
}
