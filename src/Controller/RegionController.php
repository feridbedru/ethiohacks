<?php

namespace App\Controller;

use App\Entity\Region;
use App\Entity\Zone;
use App\Entity\Woreda;
use App\Form\RegionType;
use App\Form\ZoneType;
use App\Form\WoredaType;
use App\Repository\RegionRepository;
use App\Repository\ZoneRepository;
use App\Repository\WoredaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


/**
 * @Route("/region")
 */
class RegionController extends AbstractController
{
    /**
     * @Route("/", name="region_index", methods={"GET","POST"})
     */
    public function index(RegionRepository $regionRepository, Request $request,PaginatorInterface $paginator): Response
    {
        if($request->request->get('edit')){
          
            $id=$request->request->get('edit');
            $region=$regionRepository->find($id);
            $form = $this->createForm(RegionType::class, $region);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
    
                return $this->redirectToRoute('region_index');
            }
            $queryBuilder=$regionRepository->findRegion($request->query->get('search'));
            $data=$paginator->paginate(
                $queryBuilder,
                $request->query->getInt('page',1),
                10
            );
            return $this->render('region/index.html.twig', [
                'regions' => $data,
                'form' => $form->createView(),
                'edit'=>$id
            ]);

        }

        $region = new Region();
        $form = $this->createForm(RegionType::class, $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($region);
            $entityManager->flush();
 
            return $this->redirectToRoute('region_index');
        }

        $queryBuilder=$regionRepository->findRegion($request->query->get('search'));
        $data=$paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page',1),
            10
        );
        return $this->render('region/index.html.twig', [
            'regions' => $data,
            'form' => $form->createView(),
            'edit'=>false
        ]);
        
    }

     /**
     * @Route("/zone/{id}", name="zonal_woreda", methods={"GET","POST"})
     */
    public function showworeda(Zone $zone, WoredaRepository $woredaRepository, ZoneRepository $zoneRepository, Request $request): Response
    {
        if($request->request->get('edit')){
          
            $id=$request->request->get('edit');
            $woreda=$woredaRepository->find($id);
            $form = $this->createForm(WoredaType::class, $woreda);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
    
                return $this->redirectToRoute('zonal_woreda',["id"=>$zone->getId()]);
            }
            $region = $zone->getRegion();
            return $this->render('region/woreda.html.twig', [
                'woredas' => $woredaRepository->findBy(['zone'=>$zone]),
                'zone' => $zone,
                'region' => $region,
                'form' => $form->createView(),
                'edit'=>$id
            ]);

        }

        $woreda = new Woreda();
        $form = $this->createForm(WoredaType::class, $woreda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $woreda->setZone($zone);
            $entityManager->persist($woreda);
            $entityManager->flush();
 
            return $this->redirectToRoute('zonal_woreda',["id"=>$zone->getId()]);
        }
        $region = $zone->getRegion();
        $woredas = $woredaRepository->findBy(['zone'=>$zone->getId()]);
        $zones = $zoneRepository->findOneBy(['region'=>$zone->getRegion()]);

       
        return $this->render('region/woreda.html.twig', [
            // 'woreda' => $woredaRepository->findBy(['zone'=>$zone]),
            'woredas' => $woredas,
            'zone' => $zones,
            'region' => $region,
            'form' => $form->createView(),
            'edit'=>false
        ]); 
    }

    /**
     * @Route("/{id}", name="regional_zone", methods={"GET","POST"})
     */
    public function showzone(Region $region, ZoneRepository $zoneRepository, Request $request): Response
    {
        if($request->request->get('edit')){
          
            $id=$request->request->get('edit');
            $zone=$zoneRepository->find($id);
            $form = $this->createForm(ZoneType::class, $zone);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
    
                return $this->redirectToRoute('regional_zone',["id"=>$region->getId()]);
            }
            return $this->render('region/zone.html.twig', [
                'zones' => $zoneRepository->findBy(['region'=>$region]),
                'region' => $region,
                'form' => $form->createView(),
                'edit'=>$id
            ]);

        }

        $zone = new Zone();
        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $zone->setRegion($region);
            $entityManager->persist($zone);
            $entityManager->flush();
 
            return $this->redirectToRoute('regional_zone',["id"=>$region->getId()]);
        }

       
        return $this->render('region/zone.html.twig', [
            'zones' => $zoneRepository->findBy(['region'=>$region]),
            'region' => $region,
            'form' => $form->createView(),
            'edit'=>false
        ]);
    }

    /**
     * @Route("/{id}", name="region_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Region $region): Response
    {
        if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($region);
            $entityManager->flush();
        }

        return $this->redirectToRoute('region_index');
    }

    /**
     * @Route("/{id}", name="zone_delete", methods={"DELETE"})
     */
    public function deleteZone(Request $request, Zone $zone): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zone->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($zone);
            $entityManager->flush();
        }

        return $this->redirectToRoute('zone_index');
    }

    /**
     * @Route("/zone/{id}", name="woreda_delete", methods={"DELETE"})
     */
    public function deleteWoreda(Request $request, Woreda $woreda): Response
    {
        if ($this->isCsrfTokenValid('delete'.$woreda->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($woreda);
            $entityManager->flush();
        }

        return $this->redirectToRoute('woreda_index');
    }
}
