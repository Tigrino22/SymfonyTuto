<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Reference;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route(
        '/insert',
        name: 'insert'
    )]    
    /**
     * insert
     *
     * @param  mixed $request
     * @return Response
     */
    public function insert(Request $request, Session $session): Response
    {

        $produit = new Produit;

        $formProduit = $this->createForm(ProduitType::class, $produit);
        $formProduit->add('creer', SubmitType::class, [
            'label' => 'Insertion d\'un produit'
        ]);

        $formProduit->handleRequest($request);

        if ($request->isMethod('POST') && $formProduit->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $file = $formProduit['lienImage']->getData();

            $reference = $formProduit['reference']['numero']->getData();
            
            if ($reference === null) {

                $reference = new Reference;
                $reference->setNumero(rand());
                $produit->setReference($reference);
            }

            if (!is_string($file)) {
                
                $extension = $file->guessExtension();
                $filename = uniqid(). '.' .$extension;

                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
                $produit->setLienImage($filename);
            } else {

                $session->start();
                $session->getFlashBag()
                    ->add('message', 'Vous devez saisir une image');
                $session->set('statut', 'danger');

                return $this->redirect($this->generateUrl('insert'));
            }

            $em->persist($produit);
            $em->flush();

            $session->start();
            $session->getFlashBag()
                ->add('message', 'Un nouveau produit a été ajouté');
            $session->set('statut', 'success');

            return $this->redirect($this->generateUrl('liste'));
        }

        return $this->render('admin/create.html.twig', [
            'my_form' => $formProduit->createView()
        ]);
    }

    #[Route(
        '/update/{id}', 
        name: 'update'
    )]    
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return Response
     */
    public function update(Request $request, $id, Session $session): Response
    {

        // Récuparation produit
        $em = $this->getDoctrine()->getManager();
        $repositoryProduit = $em->getRepository(Produit::class);
        $produit = $repositoryProduit->find($id);

        $img = $produit->getLienImage();

        // Création formulaire
        $formProduit = $this->createForm(ProduitType::class, $produit);
        $formProduit->add('update', SubmitType::class, [
            'label' => 'Mise à jour d\'un produit'
        ]);

        $formProduit->handleRequest($request);

        // Analyse et traitement de la requête
        if ($request->isMethod('POST') && $formProduit->isValid()) {

            $file = $formProduit['lienImage']->getData();

            if (!is_string($file)) {
                
                $extension = $file->guessExtension();
                $filename = uniqid(). '.' .$extension;

                $file->move(
                    $this->getParameter('images_directory'),
                    $filename
                );
                $produit->setLienImage($filename);

            } else {

                $produit->setLienImage($img);
            }

            $em->persist($produit);
            $em->flush();

            $session->start();
            $session->getFlashBag()
                ->add('message', 'Le produit a été mis à jour');
            $session->set('statut', 'success');

            return $this->redirect($this->generateUrl('liste'));
        }

        return $this->render('admin/create.html.twig', [
            'my_form' => $formProduit->createView()
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]    
    /**
     * delete
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    public function delete(Request $request, $id, Session $session)
    {

        $em = $this->getDoctrine()->getManager();
        $repositoryProduit = $em->getRepository(Produit::class);
        $produit = $repositoryProduit->find($id);

        $em->remove($produit);
        $em->flush();

        $session->getFlashBag()->add('message', 'Produit supprimé avec succès');
        $session->set('statut', 'success');

        return $this->redirect($this->generateUrl('liste'));

    }
}
