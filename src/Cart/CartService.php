<?php
namespace App\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

Class CartService{

    protected $productRepository;
    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    /**
     * On ajoute un produit en session
     */
    public function add(int $id, $session){
         // 1. retrouver le panier dans la session (sous forme de tableau)
        // 2. Le Deuxiéme argument est la valeur par défaut de l'attribue 
       //de la session si elle n'existe pas 
       //=>Si il n'existe pas encore, alors prendre un tableau vide
       $cart = $session->get('cart', []);

       // 3. Voir si le produit ($id) existe dèja dans le tableau
       // 4. Si c'est le cas, simplement augmenter la quantité
       // 5. Sinon ajouter le produit avec la quantité 1
       if(!array_key_exists($id, $cart)){
           $cart[$id] = 0;
       } 
           $cart[$id]++;

       // 6. Sauvegarder un attribue dans une session => 
       //Enregistrer le tableau mis à jour dans la session
       $session->set('cart', $cart);
    }

    /**
     * On récupére le total du montant en multipliant la quantité de produits mis en panier et le prix
     */
    public function getTotal($session): int{
        $total = 0;
        foreach($session->get('cart', []) as $id => $qty){
            $product = $this->productRepository->find($id);

            if(!$product){
                continue;
            }
            $total += $product->getPrice() * $qty;
        }
        return $total;
    }

    /**
     * On va chercher les produits en bdd et les quantités en session pour pouvoir les afficher dans le panier
     */
    public function getDetailedCartItems($session): array{

        $detailedCart = [];

        foreach($session->get('cart', []) as $id => $qty){
            $product = $this->productRepository->find($id);

            if(!$product){
                continue;
            }
            
            $detailedCart[] = new CartItem($product, $qty);
        }
        return $detailedCart;
    }

    public function remove(int $id, $session){
        $cart = $session->get('cart', []);

        unset($cart[$id]);

        $session->set('cart', $cart);
    }

    public function decrement(int $id, $session){
        $cart = $session->get('cart', []);

        if(!array_key_exists($id, $cart)){
            return;
        }

        //Soit le produit est à 1 alors il faut le supprimé, soit il est a plus de 1 et il faut le décrémenté
        if($cart[$id] === 1){
            $this->remove($id, $session);
            return;
        }

        $cart[$id]--;

        $session->set('cart', $cart);
    }
}

