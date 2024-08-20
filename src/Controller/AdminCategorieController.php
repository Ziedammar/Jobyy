<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategorieController extends AbstractController
{

    /**
     * @return Response
     * @Route("admin/categorie-add",name="categorie-add")
     */
    public function ajoutcat( Request $request, EntityManagerInterface $em)
    {
        $categorie=new Categorie();
        $form= $this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute("admindash");
        }
        return $this->render('admin/template/categorie-add.html.twig',[
            'categorie'=>$categorie,
            'form'=>$form->createView(),

        ]);
    }


    /**
     * @Route("/admin/categorie/supp/{id}", name="admin_categorie_suppression")
     */
    public function supprimercat($id,CategorieRepository $repository)
    {
        $categorie=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("categorie_forma_admin");


    }
    /**

     * @Route("/admin/categorie/modif/{id}", name="admin_categorie_modification", methods="GET|POST")
     */
    public function modificationcat(Categorie $categorie, Request $request,EntityManagerInterface $em)
    {
        $form= $this->createForm(CategorieType::class,$categorie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($categorie);
            $em->flush();
            $this->addFlash("success","La modification a été éffectuée");
            return $this->redirectToRoute("categorie_forma_admin");
        }
        return $this->render('admin/template/modificationcategorie.html.twig',[
            "categorie"=>$categorie,
            "form"=>$form->createView()

        ]);
    }


    /**
     * @return Response
     * @Route("/admin/categorie_aff_admin",name="categorie_forma_admin")
     */
    public function affichercat(CategorieRepository $repository): Response
    {
        $categories=$repository->findAll();
        return $this->render('admin/template/table-cat.html.twig',[
            "categories"=>$categories
        ]);
    }

}
