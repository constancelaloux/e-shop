<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/create", name="category_create")
     */
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $category->setSlug(strtolower($slugger->slug($category->getName())));
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }

        $formView = $form->createView();

        return $this->render('category/create.html.twig', [
            'formView' => $formView
        ]);
    }

    /**
     * @Route("/admin/category/{id}/edit", name="category_edit")
     */
    public function edit(int $id, CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        //Je vais chercher les données en base en fonction de l'id que l'on a fourni
        $category = $categoryRepository->find($id);

        $form = $this->createForm(CategoryType::class, $category);

        //Je récupére la requéte
        $form->handleRequest($request);

        //Si le formulaire est soumis et que le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) 
        {
            //J'ajoute les données à l'entité Category
            $category->setSlug(strtolower($slugger->slug($category->getName())));
            //Je persiste les données et je les envois dans la base de données
            //$em->persist($category);
            //dd($category);
            $em->flush();
            //Je renvoi vers la route homepage
            return $this->redirectToRoute('homepage');
        }

        //Je créais le formulaire 
        $formView = $form->createView();

        //J'envoi les données de category et le formulaire à la vue
        return $this->render('category/edit.html.twig', [
            'formView' => $formView,
            'category' => $category
        ]);
    }
}
