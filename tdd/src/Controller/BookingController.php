<?php

namespace App\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'booking')]
    public function index(EntityManagerInterface $roomRepository): Response
    {

        $rooms = $roomRepository->getRepository(Room::class)->findAll();

        return $this->render('booking/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    #[Route('/room', name: 'room')]
    public function booking(Request $request): Response {


        return $this->render('booking/booking.html.twig', [

        ]);
    }
}
