<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Offre;
use App\Form\BlogType;
use App\Repository\AdminRepository;
use App\Repository\BlogRepository;
use App\Repository\CandidateRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/listp", name="blog_indexp", methods={"GET"})
     */
    public function indexp(BlogRepository $blogRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled',TRUE);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('admin/blog/indexp.html.twig', [
            'blogs' => $blogRepository->findAll(),

        ]);

        $dompdf->loadHtml($html);
        // Load HTML to Dompdf

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
    /**
     * @Route("/listbackend", name="blog_index_backend", methods={"GET"})
     */
    public function indexbackend(BlogRepository $blogRepository): Response
    {
        $donnees =$blogRepository->findBy(array(), array('titre' => 'ASC'));

        return $this->render('admin/blog/index.html.twig', [
            'blogs' => $donnees,

        ]);
    }

    /**
     * @Route("/newbackend", name="blog_new_backend", methods={"GET","POST"})
     */
    public function newbackend(Request $request, AdminRepository  $repository, \Swift_Mailer $mailer): Response
    {
        $blog = new Blog();
        $x = $this->getUser()->getUsername();
        $y = $repository->find($x);


$blog->setUser($this->getUser()->getUsername());
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('blog')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $blog->setImage('uploads/' . $filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('send@example.com')
                ->setTo($y->getEmail())
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'emails/try.html.twig'

                    ),
                    'text/html'
                );

            $mailer->send($message);
            return $this->redirectToRoute('blog_index_backend');

        }

        return $this->render('admin/blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backend{id}", name="blog_show_backend", methods={"GET"})
     */
    public function showbackend(Blog $blog): Response
    {
        return $this->render('admin/blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/{id}/editbackend", name="blog_edit_backend", methods={"GET","POST"})
     */
    public function editbackend(BlogRepository $blogr, Request $request, Blog $blog, $id): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        $user = $blogr->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('blog')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $user->setImage('uploads/' . $filename);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blog_index_backend');
        }

        return $this->render('admin/blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backend{id}", name="blog_delete_backend", methods={"DELETE"})
     */
    public function deletebackend(Request $request, Blog $blog): Response
    {
        if ($this->isCsrfTokenValid('delete' . $blog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog_index_backend');
    }

    /**
     * @Route("/list", name="blog_index", methods={"GET"})
     */
    public function index(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/index.html.twig', [
            'blogs' => $blogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="blog_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('blog')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $blog->setImage('uploads/' . $filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($blog);
            $entityManager->flush();

            return $this->redirectToRoute('blog_index');
        }

        return $this->render('blog/new.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="blog_show", methods={"GET"})
     */
    public function show(Blog $blog): Response
    {
        return $this->render('blog/show.html.twig', [
            'blog' => $blog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="blog_edit", methods={"GET","POST"})
     */
    public function edit(BlogRepository $blogr, Request $request, Blog $blog, $id): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);
        $user = $blogr->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $blog->find($id);
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $request->files->get('blog')['image'];
                $uploads_directory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $user->setImage('uploads/' . $filename);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('blog_index');
            }
        }

        return $this->render('blog/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="blog_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Blog $blog): Response
    {
        if ($this->isCsrfTokenValid('delete' . $blog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('blog_index');
    }




}