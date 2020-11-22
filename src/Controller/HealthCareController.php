<?php

namespace App\Controller;

use App\Entity\HealthCare;
use App\Entity\HealthCareFacility;
use App\Form\HealthCareType;
use App\Form\HealthCareFacilityType;
use App\Repository\HealthCareRepository;
use App\Repository\HealthCareFacilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

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
     * @Route("/{id}", name="health_care_show", methods={"GET","POST"})
     */
    public function show(HealthCare $healthCare, HealthCareFacilityRepository $healthCareFacilityRepository,Request $request, PaginatorInterface $paginator): Response
    {
        if($request->request->get('edit')){ 
            $id=$request->request->get('edit');
            $type=$healthCareFacilityRepository->findOneBy(['id'=>$id]);
            $form = $this->createForm(HealthCareFacilityType::class, $type);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash("success","updated Successfully!!!");
    
                return $this->redirectToRoute('health_care_show', ["id"=>$healthCare->getId()]);
            }

            $queryBuilder=$healthCareFacilityRepository->findFacility($request->query->get('search'), $healthCare);
            $data=$paginator->paginate(
                $queryBuilder,
                $request->query->getInt('page',1),
                18
            );
            return $this->render('health_care/facility.html.twig', [
                'health_care_facilities' => $data,
                'health_care' => $healthCare,
                'form' => $form->createView(),
                'edit'=>$id
            ]);
        }

        $healthCareFacility = new healthCareFacility();
        $form = $this->createForm(HealthCareFacilityType::class, $healthCareFacility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $healthCareFacility->setHealthCare($healthCare);
            $entityManager->persist($healthCareFacility);
            $entityManager->flush();
            $this->addFlash("success","Registered Successfully!!!");

            return $this->redirectToRoute('health_care_show', ["id"=>$healthCare->getId()]);
        }


        $queryBuilder=$healthCareFacilityRepository->findFacility($request->query->get('search'), $healthCare);
        
        $data=$paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page',1),
            18
        );
        return $this->render('health_care/facility.html.twig', [
            'health_care_facilities' => $data,
            'health_care' => $healthCare,
            'form' => $form->createView(),
            'edit'=>false
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

    /**
     * @Route("/{id}", name="health_care_facility_delete", methods={"DELETE"})
     */
    public function deletefacility(Request $request, HealthCareFacility $healthCareFacility): Response
    {
        if ($this->isCsrfTokenValid('delete'.$healthCareFacility->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($healthCareFacility);
            $entityManager->flush();
        }

        return $this->redirectToRoute('health_care_facility_index');
    }
}
