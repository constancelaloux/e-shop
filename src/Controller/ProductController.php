<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
=======
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
>>>>>>> 6b9c5b6 (i ve created a form to create products)

class ProductController extends AbstractController
{
    /**
     * @Route("/{slug}", name="product_category")
     */
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

    /**
<<<<<<< HEAD
     * @Route("/{category_slug}/{slug}", name="product_show")
=======
     * @Route("/category/{category_slug}/{slug}", name="product_show")
>>>>>>> 6b9c5b6 (i ve created a form to create products)
     */
    public function show(string $slug, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);
<<<<<<< HEAD

=======
>>>>>>> 6b9c5b6 (i ve created a form to create products)
        if (!$product) {
            throw $this->createNotFoundException("Le produit demandé n'existe pas");
        }
        return ($this->render('product/show.html.twig', ['product' => $product]));
    }

    /**
     * @Route("/admin/product/create", name="product_create")
     */
<<<<<<< HEAD
    public function create(FormFactoryInterface $factory): Response
    {
        $builder = $factory->createBuilder();

        $builder->add('name', TextType::class, [
                    'label' => 'Nom du produit',  
                    'attr' => ['placeholder' => 'Tapez le nom du produit']])
                ->add('shortDescription', TextareaType::class, [
                    'label' => 'Description courte', 
                    'attr' => [
                        'placeholder' => 'Tapez une description assez courte mais parlante pour le visiteur']])
                ->add('price', MoneyType::class, [
                    'label' => 'Prix du produit',  
                    'attr' => [
                        'placeholder' => 'Prix du produit en €']])
                ->add('category', EntityType::class, [
                    'label' => 'Catégorie',  
                    'placeholder' => '-- Choisir une catégorie --',
                    'class' => Category::class,
                    'choice_label' => function(Category $category){
                        return strtoupper($category->getName());
                    }
                ]);

        $form = $builder->getForm();
=======
    public function create(FormFactoryInterface $factory, Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProductType::class);

        $form->handleRequest($request);
        
        if($form->isSubmitted())
        {
            $product = $form->getData();
            $product->setSlug(strtolower($slugger->slug($product->getName())));
            $em->persist($product);
            $em->flush();
        }
>>>>>>> 6b9c5b6 (i ve created a form to create products)
        $formView = $form->createView();

        return $this->render('product/create.html.twig', [
            'formView' => $formView 
        ]);
    }
}