<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Formation;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }


    /**
     * @Route("/api/{id}/edit", name="api_event_edit", methods={"PUT"})
     */
    public function majEvent(?Event $calendar, Request $request)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());

 {
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if (!$calendar) {
                // On instancie un rendez-vous
                $calendar = new Event();

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $calendar->setNom($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setDate(new DateTime($donnees->start));
            $calendar->setDatefin(new DateTime($donnees->end));
        }

            $calendar->setBackcolor($donnees->backgroundColor);
            $calendar->setBorderColor($donnees->borderColor);
            $calendar->setTextColor($donnees->textColor);

            $em = $this->getDoctrine()->getManager();
            $em->persist($calendar);
            $em->flush();

            // On retourne le code
            return new Response('Ok', $code);
        }


    /**
     * @Route("/apiform/{id}/edit", name="api_form_edit", methods={"PUT"})
     */
    public function majForm(?Formation $calendar, Request $request)
    {
        // On récupère les données
        $donnees = json_decode($request->getContent());

        if(
            isset($donnees->title) && !empty($donnees->title) &&
            isset($donnees->start) && !empty($donnees->start) &&
            isset($donnees->description) && !empty($donnees->description) &&
            isset($donnees->backgroundColor) && !empty($donnees->backgroundColor) &&
            isset($donnees->borderColor) && !empty($donnees->borderColor) &&
            isset($donnees->textColor) && !empty($donnees->textColor)
        ){
            // Les données sont complètes
            // On initialise un code
            $code = 200;

            // On vérifie si l'id existe
            if(!$calendar){
                // On instancie un rendez-vous
                $calendar = new Formation();

                // On change le code
                $code = 201;
            }

            // On hydrate l'objet avec les données
            $calendar->setNom($donnees->title);
            $calendar->setDescription($donnees->description);
            $calendar->setDate(new DateTime($donnees->start));
            $calendar->setDatefin(new DateTime($donnees->end));
        }

        $calendar->setBackcolor($donnees->backgroundColor);
        $calendar->setBordercolor($donnees->borderColor);
        $calendar->setTextcolor($donnees->textColor);

        $em = $this->getDoctrine()->getManager();
        $em->persist($calendar);
        $em->flush();

        // On retourne le code
        return new Response('Ok', $code);




    }


}