<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Map;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\CandidateRepository;
use App\Repository\UserRepository;
use App\Repository\MapRepository;
use GcampBundle\Entity\Camp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/listbackend", name="event_index_backend", methods={"GET"})
     */
    public function indexbackend(EventRepository $eventRepository): Response
    {
        return $this->render('admin/event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }
    /**
     * @Route("/newbackend", name="event_new_backend", methods={"GET","POST"})
     */
    public function newbackend(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('event')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $event->setImage('uploads/' . $filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index_backend');
        }

        return $this->render('admin/event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/backend", name="event_show_backend", methods={"GET"})
     */
    public function showbackend(Event $event): Response
    {
        return $this->render('admin/event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/editbackend", name="event_edit_backend", methods={"GET","POST"})
     */
    public function editbackend(EventRepository $eventr,Request $request2, Event $event2,$id): Response
    {
        $form = $this->createForm(EventType::class, $event2);
        $form->handleRequest($request2);
        $user=$eventr->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request2->files->get('event')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $user->setImage('uploads/' . $filename);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index_backend');
        }

        return $this->render('admin/event/edit.html.twig', [
            'event' => $event2,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}dbackend", name="event_delete_backend", methods={"DELETE"})
     */
    public function deletebackend(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index_backend');
    }

    /**
     * @Route("/list", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }
    /**
     * @Route("/listp", name="eventpdf", methods={"GET"})
     */
    public function indexp(EventRepository $eventRepository): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled',TRUE);

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file

        $html = $this->renderView('admin/event/indexp.html.twig', [
            'events' => $eventRepository->findAll(),

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
     * @Route("/new/{id}", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserRepository $user,$id): Response
    {
        $u=$user->find($id);
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setBackcolor("#cc66ff");
            $event->setBordercolor("#440066");
            $event->setTextcolor("#ffffff");
            $event->setEntId($u->getUsername());
            $event->setParId(0);

            $file = $request->files->get('event')['image'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $event->setImage('uploads/' . $filename);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     */
    public function edit(EventRepository $eventr ,Request $request, Event $event, $id): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
$user=$eventr->find($id);
        if ($form->isSubmitted() && $form->isValid()) {
            $event->setBackcolor("#cc66ff");
            $event->setBordercolor("#440066");
            $event->setBordercolor("#ffffff");
            $file = $request->files->get('event')['image'];
                $uploads_directory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $user->setImage('uploads/' . $filename);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit2/{id}", name="edit2", methods={"GET","POST"})
     */
    public function edit2(EventRepository $eventr ,Request $request, Event $event, $id,CandidateRepository $repository): Response
    {        $ev=$eventr->find($id);

        $user=$repository->find($id);
$x=$this->getUser()->getUsername();
        $nbr2=$ev->getNbr();
        $nbb=$nbr2+1;
        $ev->setNbr($nbb);
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        $user=$eventr->find($id);
        $event->setParId(0);


            $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('events',['id'=>$x]);



    }
    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
            return $this->redirectToRoute('event_index');

        }


    }
    /**
     * Creates a form to delete a camp entity.
     *
     * @param Event $event The camp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Event $event)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $event->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    /**
     * @Route("/map/{id}", name="map_action", methods={"GET"})
     */
    public function mapAction(Event $event,$id,MapRepository $m)
    {
        $deleteForm = $this->createDeleteForm($event);



        $maps = $m->find($id);

        return $this->render('event/map.html.twig', array(
            'maps' => $maps,
            'delete_form' =>$deleteForm,

        ));
    }

/**
 * @Route("/map2/{id}", name="map_action2", methods={"GET"})
 */
public function mapAction2(Event $event,$id,MapRepository $m)
{
    $deleteForm = $this->createDeleteForm($event);



    $maps = $m->find($id);

    return $this->render('event/map2.html.twig', array(
        'maps' => $maps,
        'delete_form' =>$deleteForm,

    ));
}



}
