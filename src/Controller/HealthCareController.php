<?php

namespace App\Controller;

use App\Entity\HealthCare;
use App\Form\HealthCareType;
use App\Repository\HealthCareRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/healthcare")
 */
class HealthCareController extends AbstractController
{
    /**
     * @Route("/", name="health_care_index", methods={"GET"})
     */
    public function index(HealthCareRepository $healthCareRepository): Response
    {
        return $this->render('health_care/index.html.twig', [
            'health_cares' => $healthCareRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="health_care_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $healthCare = new HealthCare();
        $form = $this->createForm(HealthCareType::class, $healthCare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($healthCare);
            $entityManager->flush();

            return $this->redirectToRoute('health_care_index');
        }

        return $this->render('health_care/new.html.twig', [
            'health_care' => $healthCare,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="health_care_show", methods={"GET"})
     */
    public function show(HealthCare $healthCare): Response
    {
        return $this->render('health_care/show.html.twig', [
            'health_care' => $healthCare,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="health_care_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HealthCare $healthCare): Response
    {
        $form = $this->createForm(HealthCareType::class, $healthCare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('health_care_index');
        }

        return $this->render('health_care/edit.html.twig', [
            'health_care' => $healthCare,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="health_care_delete", methods={"DELETE"})
     */
    public function delete(Request $request, HealthCare $healthCare): Response
    {
        if ($this->isCsrfTokenValid('delete'.$healthCare->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($healthCare);
            $entityManager->flush();
        }

        return $this->redirectToRoute('health_care_index');
    }
}
