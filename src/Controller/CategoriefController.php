<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriefController extends AbstractController
{
    /**
     * @return Response
     * @Route("/categorie_aff",name="categorie_aff")
     */
    public function affichercat(CategorieRepository $repository): Response
    {
        $categories=$repository->findAll();
        return $this->render('formation/catformation.html.twig',[
            "categories"=>$categories
        ]);
    }
}
