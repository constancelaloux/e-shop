<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    #[Route('/category/{slug}', name: 'product_category', priority: -1)]
    public function category(string $slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['slug' => $slug]);

        if (!$category) {
            throw $this->createNotFoundException("la catégorie demandée n'existe pas");
        }
        return $this->render('product/category.html.twig', [
            'slug' => $slug,
            'category' => $category,
        ]);
    }

    #[Route('/category/{category_slug}/{slug}', name: 'product_show')]
    public function show(string $slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }
        return ($this->render('product/show.html.twig', ['product' => $product]));
    }

    #[Route('/admin/product/{id}/edit', name: 'product_find')]
    public function edit(int $id, ProductRepository $productRepository, Request $request, EntityManagerInterface $em)
    {
        $product = $productRepository->find($id);

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            
            $em->flush();

            return $this->redirectToRoute('product_show', [
                'category_slug' => $product->getCategory()->getSlug(),
                'slug' => $product->getSlug()
            ]);
        }

        $formView = $form->createView();

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'formView' => $formView
        ]);
    }

    #[Route('/admin/product/create', name: 'product_create')]
    public function create(FormFactoryInterface $factory, Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        //On instancie la class Product
        $product = new Product;

        //On créé le formulaire qui permet de créé les produits
        $form = $this->createForm(ProductType::class, $product);

        //On récupére les données de la requéte
        $form->handleRequest($request);
        
        //Si le formulaire est valide et bien soumis
        if($form->isSubmitted() && $form->isValid())
        {
            //On va chercher le slug du produit ainsi que son nom
            $product->setSlug(strtolower($slugger->slug($product->getName())));
            //On enregistre les données en bdd
            $em->persist($product);
            $em->flush();
            //Et on redirige vers la route product_show qui permet d'afficher les produits
            return $this->redirectToRoute('product_show', [
                'category_slug' => $product->getCategory()->getSlug(),
                'slug' => $product->getSlug()
            ]);
        }
        
        //On génére le formulaire
        $formView = $form->createView();

        //On fait passer le formulaire à la vue
        return $this->render('product/create.html.twig', [
            'formView' => $formView 
        ]);
    }
}