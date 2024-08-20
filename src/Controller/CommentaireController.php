<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\BlogRepository;
use App\Repository\CandidateRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
/**
* @Route("/listbackend", name="commentaire_index_backend", methods={"GET"})
*/
public function indexbackend(CommentaireRepository $commentaireRepository): Response
{
    $donnees =$commentaireRepository->findBy(array(), array('nom' => 'ASC'));
    return $this->render('admin/commentaire/index.html.twig', [
        'commentaires' =>$donnees,
    ]);
}

/**
 * @Route("/newbackend", name="commentaire_new_backend", methods={"GET","POST"})
 */
public function newbackend(Request $request, CandidateRepository $repository,BlogRepository $b , $id): Response
    {
        $user=$repository->find($id);

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $blog=$b->find($id);
        if ($form->isSubmitted() && $form->isValid()) {

            $commentaire->setBlogId($blog->getId());
            $commentaire->setUser($user->getUsername());
            $commentaire->setNom($user->getNom());
            $commentaire->setMail($user->getEmail());
            $commentaire->setMobile($user->getTel());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('commentaire_index_backend');
        }

        return $this->render('admin/commentaire/new.html.twig', [
            'commentaire' => $commentaire,

            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backend{id}", name="commentaire_show_backend", methods={"GET"})
     */
    public function showbackend(Commentaire $commentaire): Response
{
    return $this->render('admin/commentaire/show.html.twig', [
        'commentaire' => $commentaire,
    ]);
}

    /**
     * @Route("/{id}/edit", name="commentaire_edit_backend", methods={"GET","POST"})
     */
    public function editbackend(Request $request, Commentaire $commentaire): Response
{
    $form = $this->createForm(CommentaireType::class, $commentaire);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('commentaire_index_backend');
    }

    return $this->render('admin/commentaire/edit.html.twig', [
        'commentaire' => $commentaire,
        'form' => $form->createView(),
    ]);
}

    /**
     * @Route("/backendd{id}", name="commentaire_delete_backend", methods={"DELETE"})
     */
    public function deletebackend(Request $request, Commentaire $commentaire): Response
{
    if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($commentaire);
        $entityManager->flush();
    }

    return $this->redirectToRoute('commentaire_index_backend');
}
    /**
     * @Route("/list", name="commentaire_index", methods={"GET"})
     */
    public function index(CommentaireRepository $commentaireRepository): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}", name="commentaire_new", methods={"GET","POST"})
     */
    public function new(Request $request, CandidateRepository $repository,BlogRepository $b, $id): Response
    {
        $user = $this->getUser();
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $blog=$b->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setBlogId($blog->getId());
            $commentaire->setUser($user->getUsername());
            $commentaire->setNom($user->getNom());
            $commentaire->setDate(new \DateTime('now'));
            $commentaire->setMail($user->getEmail());
            $commentaire->setMobile($user->getTel());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('blog-detailn');
        }

        return $this->render('blog-detail.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commentaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commentaire $commentaire): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentaire_index');
        }

        return $this->render('commentaire/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commentaire $commentaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog-detailn');
    }
}
