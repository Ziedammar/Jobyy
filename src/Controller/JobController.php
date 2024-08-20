<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Entity\User;
use App\Form\OffreType;
use App\Repository\AdminRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\OffreRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobController extends AbstractController
{

    

    /**
     * @Route("/job", name="job")
     */
    public function index( OffreRepository  $offreRepository): Response
    {
        return $this->render('offrefront/addoffre.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }

    /**
     * @param OffreRepository $offreRepository
     * @param EntrepriseRepository $repository
     * @param \Swift_Mailer $mailer
     * @Route("/sendmail", name="sendmail")
     * @return Response
     */
    public function sendmail( OffreRepository  $offreRepository,EntrepriseRepository  $repository, \Swift_Mailer $mailer): Response
    {
        $x = $this->getUser()->getUsername();
        $y = $repository->find($x);
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($y->getEmail())

            ->setBody('Offre ended !'
            );



        $mailer->send($message);
        return $this->render('offrefront/addoffre.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }
    /**
     * @Route("/jobdetail", name="jobdetail")
     */
    public function index14( OffreRepository  $offreRepository): Response
    {
        return $this->render('for_employer/job-detail.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }
    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Offre $offre, UserRepository $userRepository): Response

    {
      
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('job');
        }

        return $this->render('job/edit.html.twig', [
            'offres' => $offre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/supp/{id}", name="delete1")
     */
    public function delete($id, OffreRepository  $repoffre)
    {
        $offre=$repoffre->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();
        return $this->redirectToRoute('job');
    }

    /**
     * @Route("/type/{type}", name="type", methods={"GET"})
     */

    public function Type(OffreRepository  $OffreRepository ,$type): Response
    {
        $offretype = $OffreRepository ->findBy(['id' => $type]);
        return $this->render('for_employer/job-detail.html.twig', [
            'offres' => $offretype,
        ]);
    }
}

