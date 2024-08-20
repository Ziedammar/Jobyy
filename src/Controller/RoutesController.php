<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Entreprise;
use App\Entity\Friendship;
use App\Entity\Offre;
use App\Entity\Reclamation;
use App\Entity\Resume;
use App\Entity\User;
use App\Form\EditCType;
use App\Form\OffreType;
use App\Form\ReclamationType;
use App\Form\EditEType;
use App\Form\RegisterType;
use App\Form\RegisterCType;
use App\Form\RegisterEType;
use App\Repository\CandidateRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FriendshipRepository;
use App\Repository\ReclamationRepository;
use App\Repository\ResumeRepository;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Bridge\Google\Transport\GmailSmtpTransport;
use Symfony\Component\Mailer\Mailer;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use App\Repository\EventRepository;
use App\Repository\ParticipantRepository;
use App\Repository\CommentaireRepository;
use App\Repository\BlogRepository;
use App\Form\CommentaireType;
use App\Entity\Commentaire;
use App\Entity\Blog;



class RoutesController extends AbstractController
{
    /**
     * @Route("/", name="routes")
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    /**
     * @Route("/accordion", name="accordion")
     */
    public function accordion(): Response
    {
        return $this->render('main_pages/accordion.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/browsecompany", name="browsecompany")
     */
    public function browsecompany(): Response
    {
        return $this->render('for_candidates/browse-company.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/browse-jobs", name="browse-jobs")
     */
    public function browse_jobs(): Response
    {
        return $this->render('for_candidates/browse-jobs.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/browse-resume", name="browse-resume")
     */
    public function browse_resume(): Response
    {
        return $this->render('for_employer/browse-resume.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/candidate-profile/{id}", name="candidate-profile")
     */
    public function candidate_profile(FriendshipRepository $repository,$id,CandidateRepository $rep): Response
    {

        /*$user=$this->getDoctrine()->getRepository(Candidate::
        class)->findOneBy(array(id));
        console.log($user);*/

        $friends=$repository->findBy(array('user'=>$id));
        $users=array();
            foreach ($friends as $friend) {

                $users[] = $rep->findOneBy(array('id' => $friend->getFriend()));
            }


        return $this->render('for_candidates/candidate-profile.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/contact/{mail}/{id}", name="contact")
     */
    public function contact(Request $request, $mail, $id): Response
    {
        $user= new Reclamation() ;
        $date=date("l jS \of F Y h:i:s A");
        $form = $this->createForm(ReclamationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setUserEmail($mail);
            $user->setUserId($id);
            $user->setSubmitDate($date);
            $user->setCstatus(0);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();
            return $this->redirectToRoute('routes');
        }

        return $this->render('contact.html.twig',
            array('form'=> $form->createView())
        );
    }
    /**
     * @Route("/create-resume", name="create-resume")
     */
    public function create_resume(): Response
    {
        return $this->render('for_candidates/create-resume.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/employer-profile", name="employer-profile")
     */
    public function employer_profile(): Response
    {
        return $this->render('for_employer/employer-profile.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/faq", name="faq")
     */
    public function faq(): Response
    {
        return $this->render('faq.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/freelancer-detail", name="freelancer-detail")
     */
    public function freelancer_detail(): Response
    {
        return $this->render('freelance_space/freelancer-detail.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/freelancers", name="freelancers")
     */
    public function freelancers(): Response
    {
        return $this->render('freelance_space/freelancers.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/freelancing", name="freelancing")
     */
    public function freelancing(): Response
    {
        return $this->render('main_pages/freelancing.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/freelancing-jobs", name="freelancing-jobs")
     */
    public function freelancing_jobs(): Response
    {
        return $this->render('freelance_space/freelancing-jobs.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/job-apply-detail", name="job-apply-detail")
     */
    public function job_apply_detail(): Response
    {
        return $this->render('for_employer/job-apply-detail.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/job-detail", name="job-detail")
     */
    public function job_detail(): Response
    {
        return $this->render('for_employer/job-detail.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }

    /**
     * @Route("/lost-password", name="lost-password")
     */
    public function lost_password(): Response
    {
        return $this->render('login_singup/lost-password.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/manage-candidate", name="manage-candidate")
     */
    public function manage_candidate(CandidateRepository $repository): Response
    {
        $users=$repository->findAll();
        return $this->render('for_employer/manage-candidate.html.twig', [
            'controller_name' => 'RoutesController',
            'users'=>$users,
        ]);
    }
    /**
     * @Route("/manage-candidate/up", name="manage-candidate-up")
     */
    public function manage_candidate_up(CandidateRepository $repository): Response
    {
        $users=$repository->findBy(array(), array('nom' => 'ASC'));
        return $this->render('for_employer/manage-candidate.html.twig', [
            'controller_name' => 'RoutesController',
            'users'=>$users,
        ]);
    }
    /**
     * @Route("/manage-candidate/down", name="manage-candidate-down")
     */
    public function manage_candidate_down(CandidateRepository $repository): Response
    {
        $users=$repository->findBy(array(), array('nom' => 'DESC'));
        return $this->render('for_employer/manage-candidate.html.twig', [
            'controller_name' => 'RoutesController',
            'users'=>$users,
        ]);
    }

    /**
     * @Route("/search-result", name="search-result")
     */
    public function search_result(CandidateRepository $repository, Request $request): Response
    {
        $rule=$request->request->get('search');
        $users=$repository->findBy(array('nom'=>$rule));
        return $this->render('for_employer/manage-candidate.html.twig', [
            'controller_name' => 'RoutesController',
            'users'=>$users,
        ]);
    }
    /**
     * @Route("/new-login-signup", name="new-login-signup")
     */
    public function new_login_signup(): Response
    {
        return $this->render('login_singup/new-login-signup.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("pricing", name="pricing")
     */
    public function pricing(): Response
    {
        return $this->render('pricing.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/resume-detail", name="resume-detail")
     */
    public function resume_detail(): Response
    {
        return $this->render('for_candidates/resume-detail.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/search-job", name="search-job")
     */
    public function search_job(): Response
    {
        return $this->render('search-job.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/search-new", name="search-new")
     */
    public function search_new(): Response
    {
        return $this->render('for_candidates/search-new.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/signin-signup", name="signin-signup")
     */
    public function signin_signup()
    {

        return $this->render('main_pages/signin-signup.html.twig'
        );
    }
    /**
     * @Route("/signup", name="signup")
     */
    public function signup(): Response
    {
        return $this->render('login_singup/new-login-signup.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }


    /**
     * @Route("/create-job", name="create-job")
     */
    public function create_job(Request $request ): Response
    {
        $offre = new Offre();
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        $var = "hello" ;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $uploadedFile = $form['logo']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('uploads_directory'),$filename);
            $offre->setLogo($filename);
            $offre->setEnteprise($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('job');
        }

        return $this->render('for_employer/create-job.html.twig', [
            'offre' => $offre,
            'form' => $form->createView(),
            'var'=>$var
        ]);
    }
    /**
     * @Route("/chating", name="chating")
     */
    public function chating(): Response
    {
        return $this->render('chat.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/company-detail", name="chat")
     */
    public function company_detail(): Response
    {
        return $this->render('for_candidates/company-detail.html.twig', [
            'controller_name' => 'RoutesController',
        ]);
    }
    /**
     * @Route("/signup-candidate", name="signup-candidate")
     */
    public function signup_candidate(Request $request , UserPasswordEncoderInterface $passwordEncoder ,AuthenticationUtils $utils): Response
    {
        $error=$utils->getLastAuthenticationError();
        $ver_token=md5(uniqid());
        $user= new Candidate() ;
        $form = $this->createForm(RegisterCType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
                $email=$request->request->get('register_c')['email'];
                $file = $request->files->get('register_c')['profilePic'];
                $uploads_directory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $user->setProfilePic('uploads/'.$filename);
            $user->setRoles(['ROLE_CANDIDATE']);
            $user->setPasschange('None');
            $user->setStatus(0);
            $user->setVerToken($ver_token);
            $passwordH = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passwordH);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();
            $transport = new GmailSmtpTransport('jobby.contact@gmail.com', 'azerty147852369');
            $mailer = new Mailer($transport);
            $email = (new Email())
                ->from('jobby.contact@gmail.com')
                ->to($email)
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Verification')
                ->text('Your verification token is: ' . $ver_token)

            ;
            $mailer->send($email);
            return $this->redirectToRoute('login');
        }



        return $this->render('login_singup/signup-candidate.html.twig',
            array('form'=> $form->createView())

        );
    }
    /**
     * @Route("/signup-entreprise", name="signup-entreprise")
     */
    public function signup_entreprise(Request $request , UserPasswordEncoderInterface $passwordEncoder ): Response
    {

        $user= new Entreprise() ;
        $ver_token=md5(uniqid());
        $form = $this->createForm(RegisterEType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $email=$request->request->get('register_e')['email'];
            $file = $request->files->get('register_e')['profilPic'];
                $uploads_directory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $user->setProfilPic('uploads/'.$filename);
            $user->setRoles(['ROLE_ENTREPRISE']);
            $user->setVerToken($ver_token);
            $passwordH = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passwordH);
            $user->setStatus(0);
            $user->setPasschange('None');
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->persist($user);
            $entitymanager->flush();
            $transport = new GmailSmtpTransport('jobby.contact@gmail.com', 'azerty147852369');
            $mailer = new Mailer($transport);
            $email = (new Email())
                ->from('jobby.contact@gmail.com')
                ->to($email)
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Verification')
                ->text('Your verification token is: ' . $ver_token)

            ;
            $mailer->send($email);
            return $this->redirectToRoute('login');
        }



        return $this->render('login_singup/signup-entreprise.html.twig' ,
            array('form'=> $form->createView())

        );
    }

    /**
     * @Route("/edit-profil/{id}/{i}", name="editC")
     */
    public function edit_profil(CandidateRepository $repository , Request $request , $i ,UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user=$repository->find($i);
        $form = $this->createForm(EditCType::class,$user);
        $form->handleRequest($request);
        $pic=$user->getProfilePic();

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $request->files->get('edit_c')['profilePic'];
                $uploads_directory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
            $user->setProfilePic('uploads/' . $filename);
            $passwordH = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passwordH);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->flush();
            return $this->redirectToRoute('candidate-profile');
        }

        return $this->render('for_candidates/edit-profil.html.twig',
            array('form'=> $form->createView())
        );
    }
    /**
     * @Route("/DeleteC/{i}", name="DeleteC")
     */
    public function DeleteC(CandidateRepository $repository , Request $request , $i ): Response
    {

        $user=$repository->find($i);

        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->remove($user);
        $entitymanager->flush();
        return $this->redirectToRoute('routes');


    }
    /**
     * @Route("/edit-profilE/{id}/{i}", name="editE")
     */
    public function edit_profilE(EntrepriseRepository $repository , Request $request , $i ,UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user=$repository->find($i);
        $form = $this->createForm(EditEType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /*  echo "<pre>";
              var_dump($request); die ;*/

          $file = $request->files->get('edit_e')['profilPic'];
                $uploads_directory = $this->getParameter('uploads_directory');
                $filename = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $uploads_directory,
                    $filename
                );
                $user->setProfilePic('uploads/' . $filename);

            $passwordH = $passwordEncoder->encodePassword($user,$user->getPassword());
            $user->setPassword($passwordH);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->flush();
            return $this->redirectToRoute('employer-profile');
        }

        return $this->render('for_employer/edit-profilE.html.twig',
            array('form'=> $form->createView())
        );
    }
    /**
     * @Route("/DeleteE/{i}", name="DeleteE")
     */
    public function DeleteE(EntrepriseRepository $repository , Request $request , $i ): Response
    {

        $user=$repository->find($i);

        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->remove($user);
        $entitymanager->flush();
        return $this->redirectToRoute('routes');


    }

    /**
     * @Route("/cv/{id}", name="cv")
     */
    public function cv(ResumeRepository $repository,$id, Request $request)
    {
        $cv= new Resume();
        $martial=$request->query->get('Martial');
        $military=$request->query->get('Military');
        $interests=$request->query->get('interests');
        $education=$request->query->get('Education');
        $skills=$request->query->get('skills');
        $experience=$request->query->get('experience');
        $projects=$request->query->get('projects');

        $cv->setUserId($id);
        $cv->setEducation($education);
        $cv->setExperience($experience);
        $cv->setInterests($interests);
        $cv->setMartial($martial);
        $cv->setMilitary($military);
        $cv->setSkills($skills);
        $cv->setProjects($projects);




        return $this->render('for_candidates/cv-temp.html.twig',
        array('cv'=>$cv)
        );


    }

    /**
     * @Route("/rec/{id}", name="rec")
     */
    public function rec(ReclamationRepository $repository,$id)
    {
        $users=$repository->findBy(array('user_id'=>$id));
        return $this->render('for_candidates/showRec.html.twig',
         array('users'=>$users)
    );


    }
    /**
     * @Route("/DeleteRec/{i}", name="DeleteRec")
     */
    public function DeleteRec(ReclamationRepository $repository , Request $request , $i ): Response
    {

        $user=$repository->find($i);

        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->remove($user);
        $entitymanager->flush();
        return $this->redirectToRoute('rec');


    }

    /**
     * @Route("/ban/{i}", name="ban")
     */
    public function ban(EntrepriseRepository $repository , Request $request , $i ): Response
    {
            $user=$repository->find($i);
            $user->setStatus(1);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->flush();
            return $this->redirectToRoute('user-list');




    }
    /**
     * @Route("/unban/{i}", name="unban")
     */
    public function unban(EntrepriseRepository $repository , Request $request , $i ): Response
    {
        $user=$repository->find($i);
        $user->setStatus(0);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->flush();
        return $this->redirectToRoute('user-list');




    }
    /**
     * @Route("/banC/{i}", name="banC")
     */
    public function banC(CandidateRepository $repository , Request $request , $i ): Response
    {
        $user=$repository->find($i);
        $user->setStatus(1);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->flush();
        return $this->redirectToRoute('user-list');




    }
    /**
     * @Route("/unbanC/{i}", name="unbanC")
     */
    public function unbanC(CandidateRepository $repository , Request $request , $i ): Response
    {
        $user=$repository->find($i);
        $user->setStatus(0);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->flush();
        return $this->redirectToRoute('user-list');




    }

    /**
     * @Route("/verify", name="verify")
     */
    public function verify(CandidateRepository $repository , Request $request ): Response
    {
        $email=$request->request->get('email');
        $token=$request->request->get('token');

        $user=$repository->findOneBy(array('email'=>$email));
        if($user)
        {
        if($user->getVerToken()==$token)
        {
            $user->setVerToken('Active');
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->flush();
            return $this->redirectToRoute('login');

        }
        else{
            $this->addFlash('warning','The information you entred are wrong please check.');
        }
        }
        else{
            $this->addFlash('warning','The information you entred are wrong please check.');
        }


        return $this->render('login_singup/verify.html.twig');




    }
    /**
     * @Route("/verif", name="verif")
     */
    public function verif()
    {
        return $this->render('login_singup/verify.html.twig');
    }

    /**
     * @Route("/candidate-details/{id}", name="candidate-details")
     */
    public function candidate_details(CandidateRepository $repository , $id): Response
    {
        $user=$repository->find($id);
        return $this->render('for_candidates/user-details.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * @Route("/addfriend/{id}/{id1}", name="add_friend")
     */
    public function add_friend(FriendshipRepository $repository , $id , $id1): Response
    {
        $user= new Friendship() ;
        $user1= new Friendship() ;
        $user->setUser($id);
        $user->setFriend($id1);
        $user1->setUser($id1);
        $user1->setFriend($id);
        $entitymanager = $this->getDoctrine()->getManager();
        $entitymanager->persist($user);
        $entitymanager->flush();
        $entitymanager->persist($user1);
        $entitymanager->flush();

        return $this->redirectToRoute('manage-candidate');


    }
    /**
     * @Route("/cv-create", name="cv-create")
     */
    public function cv_create()
    {
        return $this->render('for_candidates/create-cv.html.twig');
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog( BlogRepository  $blog): Response
    {

        return $this->render('blog.html.twig', [
            'blog' => $blog->findAll(),

        ]);
    }
    /**
     * @Route("/blog-detailn", name="blog-detailn")
     */
    public function blog_detailn(BlogRepository $blog): Response
    {

        return $this->render('blog.html.twig', [
            'blog' => $blog->findAll(),
        ]);
    }
    /**
     * @Route("/blog-detail/{id}/{cat}", name="blog-detail" , methods={"GET","POST"})
     */
    public function blog_detail(CommentaireRepository $co,$id,Request $request,BlogRepository $b,$cat): Response
    {

        $comm=$co->findAll();
        $user = $this->getUser();
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        $blog=$b->find($id);
        $y= $b->findBy(array('cat' => $cat));

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setBlogId($blog->getId());
            $commentaire->setUser($user->getUsername());
            $commentaire->setNom($user->getNom());
            $commentaire->setDate(new \DateTime('now'));
            $commentaire->setMail($user->getEmail());
            $commentaire->setMobile($user->getTel());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('blog-detailn');
        }
        return $this->render('blog-detail.html.twig', [
            'blog' => $blog ,
            'comments'=>$comm,
            'blogcat' => $y,

            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/blog-detail/{id}/{cat}/{commentaire}", name="modifier_comment" , methods={"GET","POST"})
     */
    public function modifierComment(CommentaireRepository $co, Commentaire $commentaire,$id,Request $request,BlogRepository $b,$cat): Response
    {
        $comm=$co->findAll();
        $user = $this->getUser();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        $blog=$b->find($id);
        $blog=$b->find($id);
        $y= $b->findBy(array('cat' => $cat));

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setBlogId($blog->getId());
            $commentaire->setUser($user->getUsername());
            $commentaire->setNom($user->getNom());
            $commentaire->setDate(new \DateTime('now'));
            $commentaire->setMail($user->getEmail());
            $commentaire->setMobile($user->getTel());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('blog-detailn');
        }
        return $this->render('blog-detail.html.twig', [
            'blog' => $blog ,
            'comments'=>$comm,

            'blogcat' => $y,
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/events/{id}", name="events")
     */
    public function browse_event(EventRepository $eventRepository,ParticipantRepository $participantRepository, $id): Response
    {

        return $this->render('for_candidates/browse-events.html.twig', [
            'events' => $eventRepository->findAll(),
            'participants'=>$participantRepository->findOneBy(array('user'=>$id)),
        ]);

    }

    /**
     * @Route("/eventdetail/{id}/{cat}", name="eventdetail")
     */
    public function event_detail(EventRepository $eventRepository, $id,$cat): Response
    {
        $x= $eventRepository->find($id);

        $y= $eventRepository->findBy(array('categorie' => $cat));


        return $this->render('for_candidates/event-detail.html.twig', [
            'events' => $x,

            'eventcat' => $y,
        ]);
    }
    /**
     * @Route("/favoris", name="favoris")
     */
    public function favoris(EventRepository $eventRepository): Response
    {



        return $this->render('for_candidates/favoris.html.twig', [

        ]);
    }
    /**
     * @return Response
     * @Route("/codeex
    ",name="codeex
    ")
     */
    public function ex(): Response
    {
        return $this->render('admin/codeex.html.twig', [
            'controller_name' => 'TemplateController',
        ]);
    }

    /**
     * @Route("/pwdsent", name="pwdsent")
     */
    public function pwd(Request $request , CandidateRepository $repository , EntrepriseRepository $repository1): Response
    {

        $ver_token=md5(uniqid());
        $email=$request->request->get('email');
        $can=$repository->findOneBy(array('email'=> $email));
        $ent=$repository1->findOneBy(array('email'=> $email));
        if ( $can or $ent ){
            $transport = new GmailSmtpTransport('jobby.contact@gmail.com', 'azerty147852369');
            $mailer = new Mailer($transport);
            $email = (new Email())
                ->from('jobby.contact@gmail.com')
                ->to($email)
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Verification')
                ->text('Follow the link  http://127.0.0.1:8000/passchange , Your password change token is ' . $ver_token)

            ;
            $mailer->send($email);
            $can->setPasschange($ver_token);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->flush();
            return $this->redirectToRoute('login');

        }
        else{
            $transport = new GmailSmtpTransport('jobby.contact@gmail.com', 'azerty147852369');
            $mailer = new Mailer($transport);
            $email = (new Email())
                ->from('jobby.contact@gmail.com')
                ->to($email)
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Verification')
                ->text('No accounts with this mail are found on our system')

            ;
            $mailer->send($email);

            return $this->redirectToRoute('login');

        }

    }
    /**
     * @Route("/passchange", name="passchange")
     */
    public function pass(Request $request,CandidateRepository $repository,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $token=$request->request->get('token');
        $pass=$request->request->get('password');

        $user=$repository->findOneBy(array('passchange'=>$token));
        if($user) {
            $passwordH = $passwordEncoder->encodePassword($user,$pass);
            $user->setPassword($passwordH);
            $entitymanager = $this->getDoctrine()->getManager();
            $entitymanager->flush();
            return $this->redirectToRoute('login');

        }
        else{
            $this->addFlash('warning','You entred a wrong or expired token please check.');

        }
        return $this->render('login_singup/passchange.html.twig', [

        ]);
    }




}
