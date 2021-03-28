<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categoryAdmin")
 */
class CategorieAdminController extends Controller
{
    /**
     * @Route("/", name="categorie_admin_index")
     */
    /*, methods={"GET"}*/
    public function index(CategorieRepository $categorieRepository): Response
    {


        return $this->render('categorie_admin/index.html.twig', [
            'categories' => $categorieRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="categorie_admin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_admin_index');
        }

        return $this->render('categorie_admin/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_admin_show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render('categorie_admin/show.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_admin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_admin_index');
        }

        return $this->render('categorie_admin/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_admin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Categorie $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_admin_index');
    }
}