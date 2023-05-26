<?php

namespace App\Form\Type;
use App\Form\DataTransformer\CentimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    /**
     * Summary of buildForm
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param mixed $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder,array $options ): void
    {
        if($options['divide'] === false)
        {
            return;
        }
        $builder->addModelTransformer(new CentimeTransformer);
    }

    /**
     * Summary of getParent
     * @return string
     */
    public function getParent(): string
    {
        return NumberType::class;
    }

    /**
     * Summary of configureOptions
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['divide' => true]);
    }
}