<?php

namespace App\Form;

use App\Entity\Horaire;
use App\Entity\TypeHoraire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class HorairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, array('required'=>true))
            ->add('commentaire', null, array('required'=>false))
            ->add('dateHeureDebut',DateTimeType::class,
				[
					'widget' => 'choice',
					'by_reference' => true,
					'placeholder' => ''
				])
			
            ->add('dateHeureFin',DateTimeType::class,
				[
					'widget' => 'choice',
					'by_reference' => true,
					'placeholder' => ''
				])
            ->add('priorite', null, array('required'=>true))
            ->add('dateCreation', null, array('required'=>false))
            ->add('derniereModification', null, array('required'=>false))
            ->add('typeHoraire', null, array('required'=>true))
			->add('filterButton', SubmitType::class, ['label' => 'Filtrer', 'validate'=>false])
			->add('addButton', SubmitType::class, ['label' => 'Ajouter'])
			->add('orderChoice', ChoiceType::class,[
			'label' => 'Triage',
			'mapped'=>false,
			'choices'  => [
				'Aucun' => null,
				'Nom' => 'nom',
				'Date de début' => 'dateDeDebut',
				'Date de fin' => 'dateDeFin',
				'Date de création' => 'dateDeCreation'
			]])
		    ->add('ascOrDesc', ChoiceType::class,[
			'label' => ' ',
			'mapped'=>false,
			'choices'  => [
				'ASC' => 'ASC',
				'DESC' => 'DESC'
			]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Horaire::class,
        ]);
    }
}
