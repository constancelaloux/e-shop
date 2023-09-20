<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        //1. Testez l'affichage de la page d'accueil (home.html.twig) et vérifiez que la réponse est un succès (code HTTP 200).
        //2. Testez que la méthode récupère correctement les produits depuis le ProductRepository en utilisant findBy() avec les bons arguments.
        //3. Vérifiez que les produits renvoyés par la méthode sont corrects et correspondent aux attentes.
    }
}