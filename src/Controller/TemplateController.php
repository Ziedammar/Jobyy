<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Entreprise;
use App\Form\AdminType;
use App\Form\RegisterCType;
use App\Form\RegisterEType;
use App\Entity\Candidate;
use App\Repository\CategorieOffreRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use  Symfony\Bundle\MonologBundle\SwiftMailer;
use App\Repository\CandidateRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TemplateController extends AbstractController
{
    /**
     * @Route("/admindash", name="admindash")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard-1.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/user-profile", name="user_profile")
     */
    public function user_profile(): Response
    {
        return $this->render('admin/user_profile.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/user-profile-edit", name="user-profile-edit")
     */
    public function user_profile_edit(): Response
    {
        return $this->render('admin/user-profile-edit.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @Route("/user-privacy", name="user-privacy")
     */
    public function user_privacy(): Response
    {
        return $this->render('admin/user-privacy-setting.html.twig', [
            'controller_name' => 'https://www.idrlabs.com/dark-triad/mplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/user-list",name="user-list")
     */
    public function user_list(EntrepriseRepository $repository1 , CandidateRepository $repository ): Response
    {
        $candidates=$repository->findBy(array('status'=>'0'));
        $entreprises=$repository1->findBy(array('status'=>'0'));
        $bans=$repository1->findBy(array('status'=>'1'));
        $bans1=$repository->findBy(array('status'=>'1'));
        return $this->render('admin/user-list.html.twig',
            array('candidates'=>$candidates,'entreprises'=>$entreprises,'bans'=>$bans,'bans1'=>$bans1)
        );
    }
    /**
     * @return Response
     * @Route("/user-add",name="user-add")
     */
    public function user_add(Request $request , UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user= new Admin() ;
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setVerToken('Active');
            $user->setRoles(['ROLE_ADMIN']);
            $user->setStatus(0);
            $user->setType(1);
            $passwordH = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passwordH);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();
            return $this->redirectToRoute('user-add');

        }

        return $this->render('admin/user-add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @return Response
     * @Route("/user-account",name="user-account")
     */
    public function user_acc(): Response
    {
        return $this->render('admin/user-account-setting.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @return Response
     * @Route("/claimlist",name="claimlist")
     */
    public function claimlist(ReclamationRepository $repository): Response
    {
        $claims=$repository->findAll(array('Cstatus'=>0));
        $claims1=$repository->findBy(array('Cstatus'=>1));
        return $this->render('admin/todo.html.twig',
        array('claims'=>$claims,'claims1'=>$claims1));
    }

    /**
     * @return Response
     * @Route("/email_compose/{id}",name="email_compose")
     */
    public function email_compose(ReclamationRepository $repository , $id): Response
    {
        $rec=$repository->find($id);
        return $this->render('admin/email-compose.html.twig',
            array('rec'=>$rec)
        );
    }
    /**
     * @return Response
     * @Route("/solved/{id}",name="solved")
     */
    public function solved(ReclamationRepository $repository , $id): Response
    {
        $rec=$repository->find($id);
        $rec->setCstatus(1);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->flush();
        return $this->redirectToRoute('claimlist')

        ;
    }
    /**
     * @return Response
     * @Route("/reopen/{id}",name="reopen")
     */
    public function reopen(ReclamationRepository $repository , $id): Response
    {
        $rec=$repository->find($id);
        $rec->setCstatus(0);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->flush();
        return $this->redirectToRoute('claimlist')

            ;
    }
    /**
     * @return Response
     * @Route("/email",name="email")
     */
    public function email(): Response
    {
        return $this->render('admin/email.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/admindash/chat",name="chat")
     */
    public function chat(): Response
    {
        return $this->render('admin/chat.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }





    /**
     * @return Response
     * @Route("/auth-confirm-mail
    ",name="auth-confirm-mail
    ")
     */
    public function auth_confirm_mail (): Response
    {
        return $this->render('admin/auth-confirm-mail.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/auth-lock-screen
    ",name="auth-lock-screen
    ")
     */
    public function auth_lock_screen (): Response
    {
        return $this->render('admin/auth-lock-screen.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }



    /**
     * @return Response
     * @Route("/auth-recoverpw
    ",name="auth-recoverpw
    ")
     */
    public function auth_recoverpw (): Response
    {
        return $this->render('admin/auth-recoverpw.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @return Response
     * @Route("/auth-sign-in",name="auth-sign-in")
     */
    public function auth_sign_in (): Response
    {
        return $this->render('admin/auth-sign-in .html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/auth-sign-up
    ",name="auth-sign-up
    ")
     */
    public function auth_sign_up(): Response
    {
        return $this->render('admin/auth-sign-up.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/chart
    ",name="chart
    ")
     */
    public function chart(): Response
    {
        return $this->render('admin/chart.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/chart_high
    ",name="chart_high
    ")
     */
    public function chart_high(): Response
    {
        return $this->render('admin/chart_high.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/chart_morris
    ",name="chart_morris
    ")
     */
    public function chart_morris(): Response
    {
        return $this->render('admin/chart_morris.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }



    /**
     * @return Response
     * @Route("admin/tables_basic",name="offre")
     */
    public function table_basic(): Response
    {
        return $this->render('admin/admin/tables-basic.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @return Response
     * @Route("/admin/tables_data",name="tables_data")
     */
    public function data_table(): Response
    {
        return $this->render('admin/admin/table-data.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }


    /**
     * @return Response
     * @Route("/tables_tree
    ",name="tables_tree
    ")
     */
    public function tree_table(): Response
    {
        return $this->render('admin/table_tree.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }



    /**
     * @return Response
     * @Route("/table_edit
    ",name="table_edit
    ")
     */
    public function edit_table(): Response
    {
        return $this->render('admin/table_edit.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @return Response
     * @Route("/error
    ",name="error
    ")
     */
    public function error(): Response
    {
        return $this->render('admin/error.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/error500
    ",name="error500
    ")
     */
    public function error500(): Response
    {
        return $this->render('admin/error500.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }


    /**
     * @return Response
     * @Route("/pricing
    ",name="pricing
    ")
     */
    public function pricing(): Response
    {
        return $this->render('admin/pricing.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }
    /**
     * @return Response
     * @Route("/inovice
    ",name="inovice
    ")
     */
    public function inovice(): Response
    {
        return $this->render('admin/inovice.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }



    /**
     * @return Response
     * @Route("/faq
    ",name="faq
    ")
     */
    public function faq(): Response
    {
        return $this->render('admin/faq.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }


    /**
     * @return Response
     * @Route("/main
    ",name="main
    ")
     */
    public function main(): Response
    {
        return $this->render('admin/maintament.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }




    /**
     * @return Response
     * @Route("/blank
    ",name="blank
    ")
     */
    public function blank(): Response
    {
        return $this->render('admin/blankpage.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @return Response
     * @Route("/sendmailto",name="sendmailto")
     */
    public function sendmailto(Request $request): Response
    {
        $to=$request->request->get('email');
        $subject=$request->request->get('subject');
        $message=$request->request->get('message');


        $transport = new GmailSmtpTransport('jobby.contact@gmail.com', 'azerty147852369');
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from('jobby.contact@gmail.com')
            ->to($to)
            ->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($message)

        ;
        $mailer->send($email);


        return $this->redirectToRoute('claimlist');
    }

    /**
     * @return Response
     * @Route("/conf",name="conf")
     */
    public function conf(Request $request): Response
    {
        $to=$request->request->get('url');
        $transport = new GmailSmtpTransport('jobby.contact@gmail.com', 'azerty147852369');
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from('jobby.contact@gmail.com')
            ->to('dhiaeddine.khalfallah@esprit.tn')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Interview link')
            ->text("Your Interview link is : $to , Please be on time!")

        ;
        $mailer->send($email);


        return $this->redirectToRoute('routes');
    }
    /**
     * @Route("/addC", name="addC-admin")
     */
    public function addC(Request $request , UserPasswordEncoderInterface $passwordEncoder ,AuthenticationUtils $utils): Response
    {
        $error=$utils->getLastAuthenticationError();

        $user= new Candidate() ;
        $form = $this->createForm(RegisterCType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $file = $request->files->get('register_c')['profilePic'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $user->setProfilePic('uploads/'.$filename);
            $user->setRoles(['ROLE_CANDIDATE']);
            $user->setStatus(0);
            $passwordH = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passwordH);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();
            return $this->redirectToRoute('user-list');
        }



        return $this->render('admin/template/addC.html.twig',
            array('form'=> $form->createView())

        );
    }
    /**
     * @Route("/addE", name="addE-admin")
     */
    public function addE(Request $request , UserPasswordEncoderInterface $passwordEncoder ): Response
    {

        $user= new Entreprise() ;
        $form = $this->createForm(RegisterEType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $file = $request->files->get('register_e')['profilPic'];
            $uploads_directory = $this->getParameter('uploads_directory');
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $uploads_directory,
                $filename
            );
            $user->setProfilPic('uploads/'.$filename);
            $user->setRoles(['ROLE_ENTREPRISE']);
            $passwordH = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passwordH);
            $user->setStatus(0);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();
            return $this->redirectToRoute('user-list');
        }



        return $this->render('admin/template/addE.html.twig' ,
            array('form'=> $form->createView())

        );
    }
    /**
     * @return Response
     * @Route("/cms",name="cms")
     */
    public function cms(): Response
    {
        return $this->render('admin/cms.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @Route("/stat", name="stat")
     */
    public function statistiques( CategorieRepository $catrepo,FormationRepository $for){

        $categories =$catrepo->findAll();



        $categNom=[];
        $categSecteur=[];
        $categColor=[];
        $categCount =[];

        //on va démonte les données pour les séparer tel qu'attends par ChartJS
        foreach ($categories as $categorie) {
            $categNom[] = $categorie->getNom();
            $categColor[] = $categorie->getColor();
            $categCount[]=count($categorie->getIdFormation());
        }

        //On va chercher le nbr de formations par date

        $formations =  $for->CountByDate();
        $dates = [];
        $formationCount = [];

        foreach ($formations as $formation) {

            $dates[] =$formation['dateFormations'];
            $formationCount[] =$formation['count'];


        }


        $formations =  $for->CountBySecteur();
        $datas = [];
        $secteurCount = [];


        foreach ($formations as $formation) {

            $datas[] =$formation['secteurFormations'];
            $secteurCount[] =$formation['count'];

        }


        return $this->render('admin/stats.html.twig',[
            'categNom'=> json_encode($categNom),
            'categColor'=> json_encode($categColor),
            'categCount'=> json_encode($categCount),
            'dates'=> json_encode($dates),
            'formationCount'=> json_encode($formationCount),
            'datas'=> json_encode($datas),
            'secteurCount'=> json_encode($secteurCount),

        ]);

    }

    /**
     * @Route("/stats", name="stats")
     */
    public function statistique( CategorieOffreRepository $catrepo  ){


        $categories =$catrepo->findAll();



        $categNom=[];
        $categSecteur=[];
        $categColor=[];
        $categCount =[];

        //on va démonte les données pour les séparer tel qu'attends par ChartJS
        foreach ($categories as $categorie) {
            $categNom[] = $categorie->getNom();
            $categColor[] = $categorie->getColor();
            $categCount[]=count($categorie->getOffres());
        }



        return $this->render('admin/template/stat.html.twig',[
            'categNom'=> json_encode($categNom),
            'categColor'=> json_encode($categColor),
            'categCount'=> json_encode($categCount),


        ]);

    }


}
