<?php

namespace App\Controller;

use App\Entity\CategorieOffre;
use App\Form\CategorieOffreType;
use App\Repository\CategorieOffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/CategorieOffre")
 */
class CategorieOffreController extends AbstractController
{
    /**
     * @Route("/", name="CategorieOffre_index", methods={"GET"})
     */
    public function index(CategorieOffreRepository $CategorieOffreRepository): Response
    {
        return $this->render('admin/CategorieOffre/index.html.twig', [
            'CategorieOffres' => $CategorieOffreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="CategorieOffre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $CategorieOffre = new CategorieOffre();
        $form = $this->createForm(CategorieOffreType::class, $CategorieOffre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $uploadedFile = $form['logo']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $CategorieOffre->setLogo($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($CategorieOffre);
            $entityManager->flush();

            return $this->redirectToRoute('CategorieOffre_index');
        }

        return $this->render('/admin/CategorieOffre/new.html.twig', [
            'CategorieOffre' => $CategorieOffre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="CategorieOffre_show", methods={"GET"})
     */
    public function show(CategorieOffre $CategorieOffre): Response
    {
        return $this->render('CategorieOffre/show.html.twig', [
            'CategorieOffre' => $CategorieOffre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="CategorieOffre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieOffre $CategorieOffre): Response
    {
        $form = $this->createForm(CategorieOffreType::class, $CategorieOffre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('CategorieOffre_index');
        }

        return $this->render('/admin/CategorieOffre/edit.html.twig', [
            'CategorieOffre' => $CategorieOffre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="CategorieOffre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieOffre $CategorieOffre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$CategorieOffre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($CategorieOffre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/CategorieOffre_index');
    }

}
