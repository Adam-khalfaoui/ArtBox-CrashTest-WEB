<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,'categories' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            var_dump($evenement);
//            die();
            $evenement->upload();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index');
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index');
    }




    /**
     * @Route("/", name="evenement_search", methods={"POST"})
     */
    public function search(EvenementRepository $evenementRepo, Request $request)
    {
        $data=$request->get('mots');
        $evenements = $evenementRepo->search($data);
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements, 'categories' => $categories,
        ]);
    }

    /**
     * @Route("/{name}", name="evenement_cat", methods={"GET"})
     */
    public function FindByCategorie(EvenementRepository $evenementRepo, Categorie $categorie): Response
    {

        $evenements = $evenementRepo->FindByCategorie($categorie);

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements, 'categories' => $categories,
        ]);
    }

    /**
     * @Route("/back/index", name="evenement_back_index", methods={"GET"})
     */
    public function indexback(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('evenement/backindex.html.twig', [
            'evenements' => $evenements,'categories' => $categories,
        ]);
    }

    /**
     * @Route("/back/new", name="evenement_back_new", methods={"GET","POST"})
     */
    public function newback(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            var_dump($evenement);
//            die();
            $evenement->upload();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_back_index');
        }

        return $this->render('evenement/backnew.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/back/{id}", name="evenement_back_show", methods={"GET"})
     */
    public function showback(Evenement $evenement): Response
    {
        return $this->render('evenement/backshow.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/back/{id}/edit", name="evenement_back_edit", methods={"GET","POST"})
     */
    public function editback(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_back_index');
        }

        return $this->render('evenement/backedit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/back/{id}", name="evenement_back_delete", methods={"POST"})
     */
    public function deleteback(Request $request, Evenement $evenement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_back_index');
    }




    /**
     * @Route("/back/", name="evenement_back_search", methods={"POST"})
     */
    public function searchback(EvenementRepository $evenementRepo, Request $request)
    {
        $data=$request->get('mots');
        $evenements = $evenementRepo->search($data);
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('evenement/backindex.html.twig', [
            'evenements' => $evenements, 'categories' => $categories,
        ]);
    }

    /**
     * @Route("/back/{name}", name="evenement_back_cat", methods={"GET"})
     */
    public function FindByCategorieback(EvenementRepository $evenementRepo, Categorie $categorie): Response
    {

        $evenements = $evenementRepo->FindByCategorie($categorie);

        return $this->render('evenement/backindex.html.twig', [
            'evenements' => $evenements, 'categories' => $categories,
        ]);
    }

}
