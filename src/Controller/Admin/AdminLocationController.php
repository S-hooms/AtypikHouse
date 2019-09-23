<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class AdminLocationController extends AbstractController
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
     * @Route("/admin", name="admin.location.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $locations = $this->repository->findAll();
        return $this->render('admin/location/index.html.twig', compact('locations'));
    }

    /**
     * @Route("/admin/location/create", name="admin.location.new")
     */
    public function new (Request $request)
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handlerequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($location);
            $this->em->flush();
            $this->addFlash('success', 'Location Inséré avec succès !');
            return $this->redirectToRoute('admin.location.index');
        }

        return $this->render('admin/location/new.html.twig', [ 
            'location' => $location,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/location/{id}", name="admin.location.edit", methods="GET|POST")
     * @param Location $location
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(Location $location, Request $request)
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handlerequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'modifié avec succès !');
            return $this->redirectToRoute('admin.location.index');
        }

        return $this->render('admin/location/edit.html.twig', [ 
            'location' => $location,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/location/{id}", name="admin.location.delete", methods="DELETE")
     * @param Location $location
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Location $location, Request $request)
    {
        if ($this->isCsrfTokenvalid('delete' . $location->getId(), $request->get('_token')))
        {
            $this->em->remove($location);
            $this->em->flush();
            $this->addFlash('success', 'Supprimé avec succès !');
        }
        return $this->redirectToRoute('admin.location.index');
    }
}
