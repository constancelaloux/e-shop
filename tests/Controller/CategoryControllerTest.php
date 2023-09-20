<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testRenderMenuList(){
        //1. Testez que la méthode récupère correctement les catégories depuis le CategoryRepository.
        //2. Vérifiez que le rendu de la vue category/_menu.html.twig contient les données de catégories attendues.
    }

    public function create(){
        //1. Testez la soumission du formulaire avec des données valides et vérifiez que la nouvelle catégorie est correctement enregistrée en base de données.
        //2. Testez la soumission du formulaire avec des données invalides et vérifiez que le formulaire est correctement rendu avec les erreurs de validation.
        //3. Vérifiez que la redirection après la création réussie de la catégorie redirige vers la bonne route (homepage).
    }

    public function edit(){
        //1. Testez la récupération des données de catégorie en fonction de l'ID fourni.
        //2. Testez la soumission du formulaire avec des données valides et vérifiez que la catégorie est correctement mise à jour en base de données.
        //3. Testez la soumission du formulaire avec des données invalides et vérifiez que le formulaire est correctement rendu avec les erreurs de validation.
        //4. Vérifiez que la redirection après la modification réussie de la catégorie redirige vers la bonne route (homepage).
        //5. Testez le cas où la catégorie avec l'ID fourni n'existe pas, assurez-vous que l'exception NotFoundHttpException est bien levée.
    }
}