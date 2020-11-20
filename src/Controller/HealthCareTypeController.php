<?php

namespace App\Controller;

use App\Entity\HealthCareType;
use App\Form\HealthCareTypeType;
use App\Repository\HealthCareTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/healthcaretype")
 */
class HealthCareTypeController extends AbstractController
{
    /**
     * @Route("/", name="health_care_type_index", methods={"GET"})
     */
    public function index(HealthCareTypeRepository $healthCareTypeRepository): Response
    {
        return $this->render('health_care_type/index.html.twig', [
            'health_care_types' => $healthCareTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="health_care_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $healthCareType = new HealthCareType();
        $form = $this->createForm(HealthCareTypeType::class, $healthCareType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($healthCareType);
            $entityManager->flush();

            return $this->redirectToRoute('health_care_type_index');
        }

        return $this->render('health_care_type/new.html.twig', [
            'health_care_type' => $healthCareType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="health_care_type_show", methods={"GET"})
     */
    public function show(HealthCareType $healthCareType): Response
    {
        return $this->render('health_care_type/show.html.twig', [
            'health_care_type' => $healthCareType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="health_care_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HealthCareType $healthCareType): Response
    {
        $form = $this->createForm(HealthCareTypeType::class, $healthCareType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('health_care_type_index');
        }

        return $this->render('health_care_type/edit.html.twig', [
            'health_care_type' => $healthCareType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="health_care_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, HealthCareType $healthCareType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$healthCareType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($healthCareType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('health_care_type_index');
    }
}
