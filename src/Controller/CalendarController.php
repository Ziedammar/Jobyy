<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index(EventRepository $forma)

    {
        $events = $forma->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getDate()->format('Y-m-d'),
                'end' => $event->getDatefin()->format('Y-m-d'),
                'title' => $event->getNom(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackcolor(),
                'borderColor' => $event->getBordercolor(),
                'textColor' => $event->getTextcolor(),

            ];
        }

        $data = json_encode($rdvs);

        return $this->render('admin/chart_high.html.twig',compact('data'));
    }

    /**
     * @Route("/calendarf", name="calendarf")
     */
    public function call(FormationRepository $forma)

    {
        $events = $forma->findAll();

        $rdvs = [];

        foreach($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getDate()->format('Y-m-d'),
                'end' => $event->getDatefin()->format('Y-m-d'),
                'title' => $event->getNom(),
                'description' => $event->getDescription(),
                'backgroundColor' => $event->getBackcolor(),
                'borderColor' => $event->getBordercolor(),
                'textColor' => $event->getTextcolor(),

            ];
        }

        $data = json_encode($rdvs);

        return $this->render('admin/chart_highF.html.twig',compact('data'));
    }





}
