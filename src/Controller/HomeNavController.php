<?php

namespace App\Controller;

use App\Form\ReservationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeNavController extends AbstractController
{
    #[Route('/', name: 'app_home_nav')]
    public function index(): Response
    {
        return $this->render('home_nav/index.html.twig', [
            'controller_name' => 'HomeNavController',
        ]);
    }
    #[Route('/reservation', name: 'app_reservation')]
    public function reservation(): Response
    {
        $form = $this->createForm(ReservationFormType::class);
        return $this->render('home_nav/reservation.html.twig');
    }
    #[Route('/card', name: 'app_card')]
    public function card(): Response
    {
        return $this->render('home_nav/card.html.twig');
    }
}
