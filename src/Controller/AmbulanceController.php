<?php

namespace App\Controller;

use App\Entity\Ambulance;
use App\Entity\AmbulanceDriver;
use App\Form\AmbulanceType;
use App\Form\AmbulanceDriverType;
use App\Repository\AmbulanceRepository;
use App\Repository\AmbulanceDriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

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
     * @Route("/{id}", name="ambulance_show", methods={"GET","POST"})
     */
    public function show(Ambulance $ambulance, AmbulanceDriverRepository $ambulanceDriverRepository,Request $request, PaginatorInterface $paginator): Response
    {
        if($request->request->get('edit')){ 
            $id=$request->request->get('edit');
            $type=$ambulanceDriverRepository->findOneBy(['id'=>$id]);
            $form = $this->createForm(AmbulanceDriverType::class, $type);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash("success","updated Successfully!!!");
    
                return $this->redirectToRoute('ambulance_show', ["id"=>$ambulance->getId()]);
            }

            $queryBuilder=$ambulanceDriverRepository->findDriver($request->query->get('search'), $ambulance);
            $data=$paginator->paginate(
                $queryBuilder,
                $request->query->getInt('page',1),
                18
            );
            return $this->render('ambulance/driver.html.twig', [
                'ambulance_drivers' => $data,
                'ambulance' => $ambulance,
                'form' => $form->createView(),
                'edit'=>$id
            ]);
        }

        $ambulanceDriver = new AmbulanceDriver();
        $form = $this->createForm(AmbulanceDriverType::class, $ambulanceDriver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $ambulanceDriver->setAmbulance($ambulance);
            $entityManager->persist($ambulanceDriver);
            $entityManager->flush();
            $this->addFlash("success","Registered Successfully!!!");

            return $this->redirectToRoute('ambulance_show', ["id"=>$ambulance->getId()]);
        }


        $queryBuilder=$ambulanceDriverRepository->findDriver($request->query->get('search'), $ambulance);
        
        $data=$paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page',1),
            18
        );
        return $this->render('ambulance/driver.html.twig', [
            'ambulance_drivers' => $data,
            'ambulance' => $ambulance,
            'form' => $form->createView(),
            'edit'=>false
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

    /**
     * @Route("/{id}", name="ambulance_driver_delete", methods={"DELETE"})
     */
    public function deletedriver(Request $request, AmbulanceDriver $ambulanceDriver): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ambulanceDriver->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ambulanceDriver);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ambulance_show', ["id"=>$ambulanceDriver->getAmbulance()->getId()]);
    }
}
