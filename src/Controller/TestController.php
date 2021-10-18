<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route(
        path: '/test',
        name: 'test',
        methods: ['GET', 'POST']
        )]
    public function index(Session $session, Request $request): Response
    {
        $session->start();
        $session->getFlashBag()->add('message', 'Message informatif');
        $session->getFlashbag()->add('message', 'Message complémentaire');
        $session->set('statut', 'primary');

        return $this->render('test/index.html.twig');
    }

    #[Route(
        path: '/hello/{nom}/{prenom}',
        name: 'hello',
        requirements: ['nom' => '[A-Za-z]{2,50}', 'prenom' => '[A-Za-z]{2,50}']
        )]
    public function hello(Request $request, $nom = 'Toi', $prenom = ''): Response
    {
        return $this->render('test/hello.html.twig', [
            'nom' => $nom,
            'prenom' => $prenom,
        ]);
    }
}
