<?php
namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(EntityManagerInterface $em): Response
    {
        $productRepository = $em->getRepository(Product::class);
        $product = $productRepository->find(3);
        $em->remove($product);
        $em->flush();


        return $this->render('home.html.twig');
    }
}



