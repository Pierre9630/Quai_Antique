<?php

namespace App\Controller;

use App\Form\ReservationFormType;
use App\Repository\OpeningHoursRepository;
use App\Service\ResSlots;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Spatie\OpeningHours\OpeningHours;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeNavController extends AbstractController
{
    #[Route('/', name: 'app_home_nav')]
    public function index(): Response
    {
        $openingHours = OpeningHours::create([
            'monday' => ['12:00-14:00', '19:00-22:00'],
            'tuesday' => ['12:00-14:00', '19:00-22:00'],
            'thursday' => ['12:00-14:00', '19:00-22:00'],
            'friday' => ['12:00-14:00', '19:00-21:00'],
            'saturday' => ['12:00-14:00', '19:00-22:00'],
            'sunday' => ['12:00-14:00'],
        ]);
        //$session = null;
        //$session->set('openhours', $openingHours->forWeek());
        return $this->render('home_nav/index.html.twig', [
            'controller_name' => 'HomeNavController',
            'res' => $openingHours->asStructuredData('H:iP', '+01:00'),
            'openhours' => $openingHours->forWeek(),
        ]);
    }
    #[Route('/reservation', name: 'app_reservation')]
    public function reservation(OpeningHoursRepository $oh,EntityManagerInterface $em,ResSlots $resslots): Response
    {
        //$oh->getAvailableTimeSlots($oh->getDay(),)
        $form = $this->createForm(ReservationFormType::class);
        $numberslots = $resslots->getAvailableTimeSlots($em,Carbon::createFromFormat('Y-m-d H:i:s','2023-05-02 00:00:00'),2);
        //dd($numberslots);

        return $this->render('home_nav/reservation.html.twig',[
            'controller_name' => 'HomeNavController',
            'resslots' => $numberslots,

        ]);
    }
    #[Route('/card', name: 'app_card')]
    public function card(): Response
    {
        return $this->render('home_nav/card.html.twig');
    }

}
