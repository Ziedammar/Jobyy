<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoChatController extends AbstractController
{
    /**
     * @Route("/videochat", name="video_chat")
     */
    public function index(): Response
    {
        return $this->render('VideoChat/videochat.html.twig', [
            'controller_name' => 'VideoChatController',
        ]);
    }
}
