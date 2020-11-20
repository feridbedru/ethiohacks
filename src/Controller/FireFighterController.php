<?php

namespace App\Controller;

use App\Entity\FireFighter;
use App\Form\FireFighterType;
use App\Repository\FireFighterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/firefighter")
 */
class FireFighterController extends AbstractController
{
    /**
     * @Route("/", name="fire_fighter_index", methods={"GET"})
     */
    public function index(FireFighterRepository $fireFighterRepository): Response
    {
        return $this->render('fire_fighter/index.html.twig', [
            'fire_fighters' => $fireFighterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fire_fighter_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fireFighter = new FireFighter();
        $form = $this->createForm(FireFighterType::class, $fireFighter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fireFighter);
            $entityManager->flush();

            return $this->redirectToRoute('fire_fighter_index');
        }

        return $this->render('fire_fighter/new.html.twig', [
            'fire_fighter' => $fireFighter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fire_fighter_show", methods={"GET"})
     */
    public function show(FireFighter $fireFighter): Response
    {
        return $this->render('fire_fighter/show.html.twig', [
            'fire_fighter' => $fireFighter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fire_fighter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FireFighter $fireFighter): Response
    {
        $form = $this->createForm(FireFighterType::class, $fireFighter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fire_fighter_index');
        }

        return $this->render('fire_fighter/edit.html.twig', [
            'fire_fighter' => $fireFighter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fire_fighter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FireFighter $fireFighter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fireFighter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fireFighter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fire_fighter_index');
    }
}
