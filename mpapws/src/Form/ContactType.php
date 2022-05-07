<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class ContactType
 * @package App\Form
 */
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->add('object', TextType::class, ['label' => 'Objet'])
            ->add('email', TextType::class, ['label' => 'Adresse email'])
            ->add('text', TextareaType::class, ['label' => 'Veuillez écrire votre message']);

    }

    public function configureOptions(OptionsResolver $resolver){
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}