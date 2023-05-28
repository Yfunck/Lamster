<?php

namespace App\Form;

use App\Entity\Horaire;
use App\Entity\TypeHoraire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('commentaire')
            ->add('dateHeureDebut')
            ->add('dateHeureFin')
            ->add('priorite')
            ->add('dateCreation')
            ->add('derniereModification')
            ->add('typeHoraire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaire::class,
        ]);
    }
}
