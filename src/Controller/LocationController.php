<?php

namespace App\Controller;
 
use App\Entity\Location;
use App\Entity\LocationRecherche;
use App\Form\LocationRechercheType;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

use Knp\Component\Pager\PaginatorInterface;


class LocationController extends AbstractController
{
    /**
     * @var LocationRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(LocationRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="location.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $recherche = new LocationRecherche();
        $form = $this->createForm(LocationRechercheType::class, $recherche);
        $form->handleRequest($request);
        // création entité notre recherche
        // creation formulaire de recherche
        // traitement du controlleur
        $locations = $paginator->paginate(
            $this->repository->findAllVisibleQuery($recherche),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('location/index.html.twig', [
            'current-menu' => 'locations',
            'locations'=> $locations,
            'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="location.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Location $location
     * @return Response
     */
    public function show(Location $location, string $slug): Response
    {
        if ($location->getSlug() !== $slug)
        {
            $this->redirectToRoute('location.show', [
                'id' => $location->getId(),
                'slug' => $location->getSlug()
            ], 301);
        }
        return $this->render('location/show.html.twig', [
            'location' => $location,
            'current_menu' => 'locations'
        ]);
    }
}