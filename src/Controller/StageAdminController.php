<?php

namespace App\Controller;

use App\Entity\Employer;
use App\Entity\Stage;
use App\Form\StageType;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/internshipAdmin")
 */
class StageAdminController extends Controller
{
    /**
     * @Route("/", name="stage_admin_index")
     */
    /*, methods={"GET"}*/
    public function index(): Response
    {


        $stages = $this->getDoctrine()->getRepository(Stage::class)
            ->findAll();
        return $this->render('stage_admin/index.html.twig', [
            'stages' => $stages,
        ]);
    }

    /**
     * @Route("/new/{iduser}", name="stage_admin_new", methods={"GET","POST"})
     */
    public function new(Request $request, $iduser): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        $employer=$this->getDoctrine()->getRepository(Employer::class)->find($iduser);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $stage->setUser($employer);
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('stage_admin_index');
        }

        return $this->render('stage_admin/new.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_admin_show", methods={"GET"})
     */
    public function show(Stage $stage): Response
    {
        return $this->render('stage_admin/show.html.twig', [
            'stage' => $stage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stage_admin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Stage $stage): Response
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stage_admin_index');
        }

        return $this->render('stage_admin/edit.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_admin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Stage $stage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stage_admin_index');
    }

    /**
     * @Route("/update", name="stage_admin_update")
     */
    public function updateAction(StageRepository $stageRepository): Response
    {
        $stageRepository->updateDate();
        return $this->redirectToRoute('stage_admin_index');
    }

    /**
     * @Route("/triAscLib", name="stage_triAsc_libelle")
     */
    public function triAscLib(StageRepository $stageRepository)
    {
        $stages = $stageRepository->triAscLib();

        return $this->render('stage_admin/index.html.twig', array(
            'stages' => $stages));
    }

    /**
     * @Route("/triDescLib", name="stage_triDesc_libelle")
     */
    public function triDescLib(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->triDescLib();

        return $this->render('stage_admin/index.html.twig', array(
            'stages' => $stages));
    }

    /**
     * @Route("/triAscId", name="stage_triAsc_id")
     */
    public function triAscId(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->triAscId();

        return $this->render('stage_admin/index.html.twig', array(
            'stages' => $stages));
    }
    /**
     * @Route("/triDescId", name="stage_triDesc_id")
     */
    public function triDescId(StageRepository $stageRepository): Response
    {
        $stages = $stageRepository->triDescId();

        return $this->render('stage_admin/index.html.twig', array(
            'stages' => $stages));
    }

}