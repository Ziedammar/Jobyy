<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/admindash/offre")
 */
class OffreControllerADMIN extends AbstractController
{

     /**
     * @Route("/", name="offre_index", methods={"GET","POST"})
     */
    public function index(OffreRepository $offreRepository,Request $request): Response
    {

        $offre = new Offre();
        $searchForm = $this->createForm(\App\Form\SearchType::class,$offre);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {
            $nom = $searchForm['nom']->getData();
            $donnees = $offreRepository->search($nom);
            return $this->redirectToRoute('search', array('nom' => $nom));
        }
        $donnees = $this->getDoctrine()->getRepository(Offre::class)->findBy([],['nom' => 'desc']);
        return $this->render('admin/offre/index.html.twig', [
            'offres' => $donnees,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    

    /**
     * @Route("/new", name="offre_new", methods={"GET","POST"})
     */
    public function new(Request $request ): Response
    {
      
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $uploadedFile = $form['logo']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('uploads_directory'),$filename);
            $offre->setLogo($filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('offre_index');
        }

        return $this->render('admin/offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offre $offre): Response

    {

        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offre_index');
        }

        return $this->render('admin/offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("supp/{id}", name="offre_delete")
     */
    public function delete($id, OffreRepository  $repoffre)
    {
        $offre=$repoffre->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute('offre_index');
    }

    /**
     * @Route("/listh", name="listpdf", methods={"GET"})
     */
    public function listh(offreRepository $offreRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin/offre/listh.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        $dompdf -> stream( "mypdf.pdf",[

            "attachment" => false 
        ]) ; 

        return new Response("The PDF file has been succesfully generated !");
    }

        /**
     * @Route("/search/{nom}", name="search", methods={"GET","POST"})
     */
    public function search(OffreRepository $offreRepository,$nom,Request $request): Response
    {
        $offre = new Offre();
        $searchForm = $this->createForm(\App\Form\SearchType::class,$offre);
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {
            
            $nom = $searchForm['nom']->getData();
            $donnees = $offreRepository->search($nom);
            return $this->redirectToRoute('search', array('nom' => $nom));
        }
        $offre = $offreRepository->search($nom);
        return $this->render('admin/offre/index.html.twig', [
            'offres' => $offre,
            'searchForm' => $searchForm->createView()
        ]);
    }
    
}
