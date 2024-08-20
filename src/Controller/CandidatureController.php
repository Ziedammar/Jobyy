<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Data\SearchData;
use App\Form\SearchForm;
use App\Entity\Interview;
use App\Entity\Candidature;
use App\Form\InterviewType;
use App\Form\CandidatureType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Mime\Email;
use App\Repository\OffreRepository;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CandidatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @Route("/candidature")
 */
class CandidatureController extends AbstractController
{
 

    /**
     * @Route("/{id}/new/", name="candidature_post", methods={"GET","POST"})
     * @isGranted("ROLE_CANDIDATE")
     * 
     */
    public function new(Request $request , $id , OffreRepository $offreRepository): Response
    {
        $candidature = new Candidature();
        $candidature ->setCandidateId($this->getUser()) ; 
        $offre = new Offre() ; 
        $offre = $offreRepository->findOneBy(['id'=>$id]); 
        $candidature ->setOffre($offre); 
        $candidature ->setEtat('en cours') ; 
        $candidature ->setDatePostuler(new \DateTime('now'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($candidature);
        $entityManager->flush();

        return $this->redirectToRoute('job');
    
    }

      /**
     * @Route("/{id}/candidature/", name="candidature_postuler", methods={"GET","POST"})
     * @isGranted("ROLE_ENTREPRISE")
     * 
     */
    public function AfficherCandidatsPostuler(Request $request , $id , CandidatureRepository $candidatureRepository): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class , $data) ; 
        $form -> handleRequest($request) ; 
        return $this->render('candidature/candidatpostuler.html.twig', [
          'candidatures' => $candidatureRepository->findBy(['offre'=>$id]),
          'form'=>$form->createView() ,
        ]);
    }


          /**
     * @Route("/dhasbard", name="template")
     */
    public function indexb(): Response
    {
        return $this->render('backend/dashboard-1.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/moncandidatures", name="mon_candidature")
     * @isGranted("ROLE_CANDIDATE")
     * 
     */
    public function AfiicherMonCandidature(Request $request  , CandidatureRepository $candidatureRepository): Response
    {
        return $this->render('offrefront/moncandidature.html.twig', [
          'candidatures' => $candidatureRepository->findBy(['candidate_id'=>$this->getUser()]),

        ]);
    }
    
    /**
     * @Route("/{id}/candidatureinterview/", name="candidature_interview", methods={"GET","POST"})
     * @isGranted("ROLE_ENTREPRISE")
     * 
     */
    public function PickerInterview( MailerInterface $mailer  , Request $request , $id ,CandidatureRepository $candidatureRepository ,  EntityManagerInterface $entitymanager): Response
    {
        $candidature = new Candidature() ;
        $candidature = $candidatureRepository->findOneBy(['id'=>$id]) ; 

        $interview= new Interview() ;
        $form = $this->createForm(InterviewType::class, $interview);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $interview->setEnteprise($this->getUser());
            $interview->setCand($candidature); 
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($interview);
            $entitymanager->flush();

            $email = (new Email())
            ->from($this->getUser()->getEmail())
            ->to($candidature->getCandidateId()->getEmail())
            ->text("vous avez invite a faire un entretien le ". $interview->getDateTemps()->format('Y-m-d') ." avec la societe ".  $interview->getEnteprise()->getNom()."  IDoffre  => ". $interview->getCand()->getOffre()->getId())
            ->subject('Entretien ') ;
            
            $mailer->send($email);
            return $this->redirectToRoute('interview_enteprise');
        }
        return $this->render('candidature/interviewform.html.twig',
            array('form'=> $form->createView())

        );
    
    }

    /**
     * @Route("/{id}/candidatureinterview/edit", name="editer_interview", methods={"GET","POST"})
     * @isGranted("ROLE_ENTREPRISE")
     * 
     */
    public function EditerInterview(Request $request , Interview $interview  ,CandidatureRepository $candidatureRepository ,  EntityManagerInterface $entitymanager): Response
    {
        $candidature = $interview->getCand(); 
        
        $form = $this->createForm(InterviewType::class, $interview);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $interview->setEnteprise($this->getUser());
            $interview->setCand($candidature); 
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($interview);
            $entitymanager->flush();
            return $this->redirectToRoute('offre_enteprise');
        }
        return $this->render('candidature/interviewform.html.twig',
            array('form'=> $form->createView() , 'interview' =>$interview)

        );
        
    
    }
     /**
     * @Route("/{id}", name="delete_interview", methods={"DELETE"})
     * @isGranted("ROLE_ENTREPRISE")
     */
    public function delete(Request $request, Interview $interview): Response
    {
        if ($this->isCsrfTokenValid('delete'.$interview->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($interview);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offre_enteprise');
    }

   


 

}