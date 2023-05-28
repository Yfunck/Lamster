<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Entity\TypeHoraire; //Le type des horaires
use App\Form\HorairesType; //Utiliser pour le rendering des form
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class HorairesController extends AbstractController
{
    #[Route('/horaires', name: 'app_horaires')]
    public function index(Request $request): Response
    {	
		$horaire = new Horaire();
		$form = $this->createForm(HorairesType::class, $horaire, array('method'=>'GET'));
		
		$form->handleRequest($request);
		
        return $this->render('horaires/index.html.twig', [
			'form' => $form
        ]);
    }
	
	#[Route('/horaires/list', name: 'app_list')]
    public function getAllHoraire(EntityManagerInterface $entityManager, Request $request): Response
    {	
		
		$horaire = new Horaire();
		$form = $this->createForm(HorairesType::class, $horaire, array('method'=>'GET'));
		
		$horaire = $form->getData();
		
		$listeHoraires = $entityManager->getRepository(Horaire::class)->findAll();
		
		return $this->render('horaires/index.html.twig', [
			'form' => $form,
			'test' => $listeHoraires
        ]);
	}
}
