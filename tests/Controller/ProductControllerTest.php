<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testCreate() {
        //1. Testez la soumission du formulaire avec des données valides et vérifiez que le produit est correctement enregistré en base de données.
        //2. Testez la soumission du formulaire avec des données invalides et vérifiez que le formulaire est correctement rendu avec les erreurs de validation.
        //3. Testez la redirection après la création réussie du produit.
    }

    public function edit() {
        //1. Testez la soumission du formulaire avec des données valides et vérifiez que le produit est correctement mis à jour en base de données.
        //2. Testez la soumission du formulaire avec des données invalides et vérifiez que le formulaire est correctement rendu avec les erreurs de validation.
        //3. Testez la redirection après la mise à jour réussie du produit.
    }

    public function show() {
        //1. Testez l'affichage de la page product/show.html.twig lorsque le produit existe.
        //2. Testez le cas où le produit n'existe pas, vérifiez que l'exception NotFoundException est bien levée.
    }

    public function category() {
        //1. Testez l'affichage de la page product/category.html.twig lorsque la catégorie existe.
        //2. Testez le cas où la catégorie n'existe pas, vérifiez que l'exception NotFoundException est bien levée.
    }
}