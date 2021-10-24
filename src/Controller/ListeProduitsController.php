<?php

namespace App\Controller;

use App\Repository\DistributeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;

class ListeProduitsController extends AbstractController
{
    #[Route(
        '/liste',
        name: 'liste'
        )]    
    /**
     * liste
     *
     * @var ProduitRepository
     * @return Response
     */
    public function liste(ProduitRepository $produitRepository): Response
    {   
        // Pour passer par App\Entity\Produit mais avec inteliphense, remonte une erreur
        // $em = $this->getDoctrine()->getManager();
        // $produitRepository = $em->getRepository(Produit::class);

        $listeProduits = $produitRepository->orderingProduit();
        $lastProduit = $produitRepository->getLastProduit();

        return $this->render(
            'liste_produits/index.html.twig', 
            [
                'listeProduits' => $listeProduits,
                'lastProduit' => $lastProduit,
            ]);
    }


    #[Route(
        '/distrib',
        name: 'distributeurs',
    )]
    public function listeDistributeurs(DistributeurRepository $repDistributeurs)
    {


        $distributeurs = $repDistributeurs->findAll();

        return $this->render(
            'liste_produits/distributeurs.html.twig',
            [
                'distributeurs' => $distributeurs
            ]
            );
    }


}
