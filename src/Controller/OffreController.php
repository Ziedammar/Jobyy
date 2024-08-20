<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Offre;
use DateTimeInterface;
use App\Form\OffreType;
use App\Entity\Interview;
use App\Form\InterviewType;
use App\Form\SearchForm;
use App\Repository\OffreRepository;
use App\Repository\InterviewRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
{
   
    

    /**
     * @Route("/myoffre", name="offre_enteprise", methods={"GET"})
     * @isGranted("ROLE_ENTREPRISE")
     */
    public function myOffre(OffreRepository $offreRepository): Response
    {

        return $this->render('offrefront/entepriseoffre.html.twig', [
            'offres' => $offreRepository->findBy(['enteprise'=>$this->getUser()]),

        ]);
    }

    /**
     * @Route("/myinterview", name="interview_enteprise", methods={"GET"})
     */
    public function myinterview(InterviewRepository $interviewRepository , Request $request): Response
    {
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class , $data) ; 
        $form->handleRequest($request) ;
        $interview= $interviewRepository->findSearch($data);
        


        return $this->render('offrefront/entepriseinterview.html.twig', [
            'interviews' => $interview ,
            'form'=>$form->createView()

        ]);
    }

     /**
     * @Route("/myinterview_date", name="interview_enteprise_date", methods={"GET"})
     */
    public function myinterviewpardate(Request $request , InterviewRepository $interviewRepository): Response
    {
        $interviews= $interviewRepository->sortByDate();
      
        return $this->render('offrefront/entepriseinterview.html.twig', [
            'interviews' =>  $interviews

        ]);
    
    }
    /**
     * @Route("/myinterviewcalender", name="interview_enteprise_calender", methods={"GET"})
     */
    public function myinterviewcalender(InterviewRepository $interviewRepository): Response
    {

        $interviews = $interviewRepository->findBy(['enteprise'=>$this->getUser()]);
        $rdv  = [] ; 
        foreach ($interviews as $interview) {
            $new_time = date($interview->getDateTemps()->format('Y-m-d H:m:s'), strtotime('+1 hours')) ;
            $rdv [] = [
                'id' =>  $interview->getId(),
                'start' => $interview->getDateTemps()->format('Y-m-d H:m:s'),
                'end' => $new_time   ,
                'title' => $interview->getCand()->getCandidateId()->getNom() ,
              
               
            ] ;
        }
        $data = json_encode($rdv) ;
        return $this->render('offrefront/entepriseinterviewcalender.html.twig',  compact('data'));
    }


   
}