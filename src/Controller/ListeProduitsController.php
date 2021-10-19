<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;

class ListeProduitsController extends AbstractController
{
    #[Route(
        '/liste',
        name: 'liste'
        )]
    public function liste(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $produitRepository = $em->getRepository(Produit::class);

        $listeProduits = $produitRepository->findAll();

        return $this->render('liste_produits/index.html.twig', [
            'listeProduits' => $listeProduits,
        ]);
    }
}
