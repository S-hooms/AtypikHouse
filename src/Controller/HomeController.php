<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

Class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param LocationRepository $repository
     * @return Response
     */
    public function index(LocationRepository $repository): Response
    {
        $locations = $repository->findlastest();
        return $this->render('pages/home.html.twig', [
            'locations' => $locations
        ]);
    }
}