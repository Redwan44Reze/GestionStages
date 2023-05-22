<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Stage;
use App\Entity\Tuteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('poste', TextType::class, [
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('type',ChoiceType::class, [
                'choices' => [ 'Oui' => true,'Non' => false,],
                'label' => 'Plein temps ?'])
            ->add('description', TextareaType::class)
            ->add('actif',ChoiceType::class, [
                'choices' => [
                    'Oui' => true,'Non' => false, ],
                'label' => 'Actif ?'])
            ->add('email', EmailType::class, [
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('societe', TextType::class, [
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('ville', TextType::class, [
                'constraints' => [new NotBlank(),
                    new Length(['max' => 255]),
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class, 'choice_label' => 'nom',])
            ->add('tuteurs', EntityType::class, [
                'class' => Tuteur::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
