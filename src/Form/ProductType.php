<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\DataTransformer\CentimeTransformer;
use App\Form\Type\PriceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class ProductType extends AbstractType
{
    /**
     * Summary of buildForm
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param mixed $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class, [
            'label' => 'Nom du produit',  
            'attr' => ['placeholder' => 'Tapez le nom du produit'],
            'required' => false
            ])
        ->add('shortDescription', TextareaType::class, [
            'label' => 'Description courte', 
            'attr' => [
                'placeholder' => 'Tapez une description assez courte mais parlante pour le visiteur']])
        ->add('price', MoneyType::class, [
            'label' => 'Prix du produit',  
            'attr' => [
                'placeholder' => 'Tapez le prix du produit en €'
            ],
            'divisor' => 100,
            'required' => false
        ])
        ->add('mainPicture', UrlType::class, [
            'label' => 'Ajouter une image',
            'attr' => ['placeholder' => 'Tapez une URL d\'image']
        ])
        ->add('category', EntityType::class, [
            'label' => 'Catégorie',  
            'placeholder' => '-- Choisir une catégorie --',
            'class' => Category::class,
            'choice_label' => function(Category $category){
                return strtoupper($category->getName());
            }
        ]);
        //$builder->get('price')->addModelTransformer(new CentimeTransformer);
    }

    /**
     * Summary of configureOptions
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
