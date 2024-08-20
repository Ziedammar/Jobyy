<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\EditCType;
use App\Form\ParticipantType;
use App\Repository\CandidateRepository;
use App\Repository\EventRepository;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participant")
 */
class ParticipantController extends AbstractController
{


    /**
 * @Route("/listbackend", name="participant_index_backend", methods={"GET"})
 */
    public function indexbackend(ParticipantRepository $participantRepository): Response
    {
        return $this->render('admin/participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/newbackend", name="participant_new_backend", methods={"GET","POST"})
     */
    public function newbackend(Request $request,CandidateRepository $repository , $id): Response
    {
        $user=$repository->find($id);
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participant->getNom($user->getNom());
            $participant->getMail($user->getEmail());
            $participant->setMobile($user->getTel());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('participant_index_backend');
        }

        return $this->render('admin/participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/backend{id}", name="participant_show_backend", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function showbackend(Participant $participant): Response
    {
        return $this->render('admin/participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/backende{id}/editbackend", name="participant_edit_backend", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function editbackend(Request $request, Participant $participant): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participant_index_backend');
        }

        return $this->render('admin/participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="participant_delete", methods={"DELETE"}, requirements={"id":"\d+"})
     */
    public function delete(Request $request, Participant $participant): Response
    {
        $user = $this->getUser();


        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events',['id'=>$this->getUser()]);
    }
    /**
     * @Route("/{id}", name="participant_delete2", methods={"DELETE"}, methods={"GET","POST"} )
     */
    public function delete2(Request $request, $id,ParticipantRepository $pa): Response
    {
        $participant=$pa->find($id);

        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('participant_index');
    }

    /**
     * @Route("/backend{id}", name="participant_delete_backend", methods={"DELETE"}, requirements={"id":"\d+"})
     */
    public function deletebackend(Request $request, Participant $participant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($participant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('participant_index_backend');
    }


    /**
     * @Route("/list", name="participant_index", methods={"GET"})
     */
    public function index(ParticipantRepository $participantRepository): Response
    {
        return $this->render('participant/index.html.twig', [
            'participants' => $participantRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{id}/{i}", name="participant_new", methods={"GET","POST"})
     */
    public function new(Request $request,CandidateRepository $repository ,EventRepository $eventRepository , $id,$i, \Swift_Mailer $mailer): Response
    {
        $user=$repository->find($id);
        $ev=$eventRepository->find($i);
        $ev->setParId($user->getUsername());
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        $nbr2=$ev->getNbr();
        $nbb=$nbr2-1;
        $ev->setNbr($nbb);
            $participant->addEvent($ev);
            $participant->setEventid($ev->getId());
            $participant->setDate(new \DateTime('now'));
            $participant->setUser($user->getUsername());
            $participant->setMail($user->getEmail());
            $participant->setNom($user->getNom());
            $participant->setMobile($user->getTel());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo($participant->getMail())

            ->setBody('subscribed successfull!'
            );

        $mailer->send($message);

        return $this->redirectToRoute('events',['id'=>$user->getUsername()]);

    }

    /**
     * @Route("/{id}", name="participant_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Participant $participant): Response
    {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="participant_edit", methods={"GET","POST"}, requirements={"id":"\d+"})
     */
    public function edit(Request $request, Participant $participant,EventRepository $eve): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participant_index');
        }

        return $this->render('participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }



}
