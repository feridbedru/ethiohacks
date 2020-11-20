<?php

namespace App\Controller;

use App\Entity\Ambulance;
use App\Form\AmbulanceType;
use App\Repository\AmbulanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ambulance")
 */
class AmbulanceController extends AbstractController
{
    /**
     * @Route("/", name="ambulance_index", methods={"GET"})
     */
    public function index(AmbulanceRepository $ambulanceRepository): Response
    {
        return $this->render('ambulance/index.html.twig', [
            'ambulances' => $ambulanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ambulance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ambulance = new Ambulance();
        $form = $this->createForm(AmbulanceType::class, $ambulance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ambulance);
            $entityManager->flush();

            return $this->redirectToRoute('ambulance_index');
        }

        return $this->render('ambulance/new.html.twig', [
            'ambulance' => $ambulance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ambulance_show", methods={"GET"})
     */
    public function show(Ambulance $ambulance): Response
    {
        return $this->render('ambulance/show.html.twig', [
            'ambulance' => $ambulance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ambulance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ambulance $ambulance): Response
    {
        $form = $this->createForm(AmbulanceType::class, $ambulance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ambulance_index');
        }

        return $this->render('ambulance/edit.html.twig', [
            'ambulance' => $ambulance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ambulance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ambulance $ambulance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ambulance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ambulance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ambulance_index');
    }
}
