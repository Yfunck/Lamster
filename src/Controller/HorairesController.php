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
    #[Route('/', name: 'app_horaires')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {	
		$horaire = new Horaire();
		$form = $this->createForm(HorairesType::class, $horaire, array('method'=>'GET'));
		$listeHoraires = $entityManager->getRepository(Horaire::class)->findAll();
		$form->handleRequest($request);
		
		
		
		if($form->isSubmitted() && $form->isValid()){
			$horaire = $form->getData();
			if($form->get('filterButton')->isClicked()){
				
				return $this->filterHoraires($horaire, $entityManager, $form);
			}
			
			if($form->get('addButton')->isClicked()){
				return $this->ajoutHoraire($entityManager, $horaire, $form);
			}
			
		}
		
        return $this->renderResponse($form, $listeHoraires);
    }
	
    public function ajoutHoraire(EntityManagerInterface $entityManager, $horaire, $form): Response
    {	
		$form = $this->createForm(HorairesType::class, $horaire, array('method'=>'GET'));
		
		$entityManager->persist($horaire);
		$entityManager->flush();
		return $this->filterHoraires(new Horaire(), $entityManager, $form);
		
	}
	
	public function renderResponse($form, $listeHoraires): Response{
		return $this->render('horaires/index.html.twig', [
				'form' => $form,
				'liste' => $listeHoraires,
			]);
	}
	
	public function filterHoraires(Horaire $horaire, EntityManagerInterface $entityManager, $form) : Response
	{
			
		$select = "SELECT h
			FROM App\Entity\Horaire h";


		$where = "";
		$where .= $horaire->getNom() ? " h.nom = '".$horaire->getNom()."' AND " : "";		
		$where .= $horaire->getCommentaire() ? " h.commentaire = '".$horaire->getCommentaire()."' AND " : "";		
		$where .= $horaire->getDateHeureDebut() ? " h.dateHeureDebut = '".$horaire->getDateHeureDebut()->format('Y-m-d H:i:s')."' AND " : "";		
		$where .= $horaire->getDateHeureFin() ? "h.dateHeureFin = '".$horaire->getDateHeureFin()->format('Y-m-d H:i:s')."' AND " : "";
		$where .= $horaire->getCommentaire() ? " h.priorite = '".$horaire->getPriorite()."' AND " : "";	
		$where .= $horaire->getDateCreation() ? "h.dateCreation = '".$horaire->getDateCration()->format('Y-m-d')."' AND " : "";
		$where .= $horaire->getDerniereModification() ? "h.derniereModification = '".$horaire->getDerniereModification()->format('Y-m-d')."' AND " : "";
		
		$order = "";
		$order .= $form['orderChoice']->getData();
		
		$select .= $where ? " WHERE ".$where : "";
		$select = rtrim($select, "AND ");
		
		$select .= $order ? " ORDER BY h.".$order : "";
		$select .= $order ? " ".$form['ascOrDesc']->getData() : "";
		 
		$query = $entityManager->createQuery($select);
		
		return $this->renderResponse($form, $query->getResult());
	}
}
