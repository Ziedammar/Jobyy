<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\User;
use App\Form\FormationType;
use App\Repository\AdminRepository;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Dompdf\Options;
class AdminFormationController extends AbstractController
{
    /**
     * @return Response
     * @Route("/admindash/add_form",name="add_form")
     */
    public function addform ( Request $request, EntityManagerInterface $em , AdminRepository $user_rep)
    {


        $formation=new Formation();

        $user = $this->getUser();

        $form= $this->createForm(FormationType::class,$formation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $formation->setBackcolor("#cc66ff");
            $formation->setBordercolor("#440066");
            $formation->setTextcolor("#ffffff");
            $formation->setStatus("0");
            $formation->addIdUser($user);
            $image =$form->get('image')->getData();
            $nomImage = md5(uniqid()).'.'.$image->guessExtension() ;
            $image->move($this->getParameter('uploads_directory'),$nomImage) ;
            $formation->setImage($nomImage) ;
            $formation->setUpdatedAt(new \DateTime('now'));
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute("admindash");
        }
        return $this->render('admin/template/addform.html.twig',[
            'formation'=>$formation,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route("/admindash/forma_aff",name="forma_aff")
     */
    public function forma_aff(FormationRepository $repository,UserRepository  $repository2): Response
    {
        $formations=$repository->findAll();
        $user = $this->getUser();
        return $this->render('admin/template/forma_aff.html.twig',[
            'formations'=>$formations,
            'user'=>$user

        ]);
    }

    /**
     * @return Response
     * @Route("/admindash/desc_aff/{id}",name="desactive_form" )
     */
    public function desactiverforma($id, FormationRepository $repository)
    {
        $formation =$repository->find($id);
        $formation->setStatus("1");
        $em=$this->getDoctrine()->getManager();
        $em->persist($formation);
        $em->flush();
        return $this->redirectToRoute('forma_aff');
    }
    /**
     * @return Response
     * @Route("/admindash/act_aff/{id}",name="active_form" )
     */
    public function activerforma($id, FormationRepository $repository)
    {
        $formation =$repository->find($id);
        $formation->setStatus("0");
        $em=$this->getDoctrine()->getManager();
        $em->persist($formation);
        $em->flush();
        return $this->redirectToRoute('forma_aff');
    }
    /**

     * @Route("/admindash/formation/modif/{id}", name="admin_formation_modification", methods="GET|POST")
     */
    public function edit(Request $request, Formation $formation, AdminRepository $user_rep): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation->setBackcolor("#cc66ff");
            $formation->setBordercolor("#440066");
            $formation->setTextcolor("#ffffff");
            $formation->setStatus("0");
            $formation->addIdUser($user);
            $image =$form->get('image')->getData();
            $nomImage = md5(uniqid()).'.'.$image->guessExtension() ;
            $image->move($this->getParameter('uploads_directory'),$nomImage) ;
            $formation->setImage($nomImage) ;
            $formation->setUpdatedAt(new \DateTime('now'));
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('forma_aff');
        }

        return $this->render('admin/template/modificationformation.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route("/listeformationcat/{id}",name="listeformationcat")
     */
    function listFormationByCat(CategorieRepository $repcat ,FormationRepository $repform ,$id )
    {
        $categorie=$repcat->find($id);
        $formation=$repform->listFormationByCat($categorie->getId());
        return $this->render('admin/template/listeformationcat.html.twig',[
            'c'=>$categorie,
            'formations'=>$formation
        ]);

    }


    /**
     * @Route("/admindash/formation/supp/{id}", name="admin_formation_suppression")
     */
    public function supprimerforma($id,FormationRepository $repository)
    {
            $formation=$repository->find($id);
            $em=$this->getDoctrine()->getManager();
            $em->remove($formation);
            $em->flush();
        return $this->redirectToRoute("forma_aff");


    }


    /**
     * @return Response
     * @Route("/listformapdf",name="listformapdf", methods={"GET"})
     */
    public function pdf(FormationRepository $repform ):Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin/template/listformapdf.html.twig', [
            $formations =$repform->findAll(),
            'formations' => $formations
        ]);

        // Load HTML to Dompdf
             $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("yas.pdf", [
            "Attachment" => true
        ]);
        return new Response('', 200, [
            'Content-Type' => 'application/pdf',
        ]);

    }

}
