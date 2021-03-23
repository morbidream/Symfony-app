<?php

namespace App\Controller;

use App\Entity\Search;
use App\Entity\Stage;
use App\Form\SearchType;
use App\Form\StageType;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;


/**
 * @Route("/stage")
 */
class StageController extends AbstractController
{

    public function indexDefault(StageRepository $stageRepository): Response
    {
        return $this->render('stage/index.html.twig', [
            'stages' => $stageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/", name="stage_index", methods={"GET", "POST"})
     */
    public function finds(Request $request)
    {
        $categorySearch = new Search();
        $form = $this->createForm(SearchType::class,$categorySearch);
        $form->handleRequest($request);

        $stages= $this->getDoctrine()->getRepository(Stage::class)->findAll();

        if($form->isSubmitted() && $form->isValid()) {
            $category = $categorySearch->getCategory();

            if ($category!="")
            {
                $stages= $this->getDoctrine()->getRepository(Stage::class)->findBy(['category' => $category] );
            }
            else
                $stages= $this->getDoctrine()->getRepository(Stage::class)->findAll();
        }

        return $this->render('stage/index.html.twig',['form' => $form->createView(),'stages' => $stages]);
    }

    /**
     * @Route("/C", name="stage_indexC", methods={"GET", "POST"})
     */
    public function findsC(Request $request)
    {
        $categorySearch = new Search();
        $form = $this->createForm(SearchType::class,$categorySearch);
        $form->handleRequest($request);

        $stages= $this->getDoctrine()->getRepository(Stage::class)->findAll();

        if($form->isSubmitted() && $form->isValid()) {
            $category = $categorySearch->getCategory();

            if ($category!="")
            {
                $stages= $this->getDoctrine()->getRepository(Stage::class)->findBy(['category' => $category] );
            }
            else
                $stages= $this->getDoctrine()->getRepository(Stage::class)->findAll();
        }

        return $this->render('stage/indexC.html.twig',['form' => $form->createView(),'stages' => $stages]);
    }

    /**
     * @Route("/new", name="stage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stage);
            $entityManager->flush();

            return $this->redirectToRoute('stage_index');
        }

        return $this->render('stage/new.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_show", methods={"GET"})
     */
    public function show(Stage $stage): Response
    {
        return $this->render('stage/show.html.twig', [
            'stage' => $stage,
        ]);
    }

    /**
     * @Route("/{id}/C", name="stage_showC", methods={"GET"})
     */
    public function showC(Stage $stage): Response
    {
        return $this->render('stage/showC.html.twig', [
            'stage' => $stage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="stage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Stage $stage): Response
    {
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stage_index');
        }

        return $this->render('stage/edit.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Stage $stage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stage_index');
    }



}
