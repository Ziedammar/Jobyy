<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\FormationDislike;
use App\Entity\FormationLike;
use App\Entity\User;
use App\Form\FormationType;
use App\Repository\CategorieRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationDislikeRepository;
use App\Repository\FormationLikeRepository;
use App\Repository\FormationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class FormationController extends AbstractController
{
    /**
     * @Route("/listforma", name="listforma")
     */
    public function forma(FormationRepository $repository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $repository->findAll();
        $formations = $paginator->paginate(
            $donnees, //on pass les données
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('formation/listforma.html.twig', [
            'formations' => $formations
        ]);
    }

    /**
     * @return Response
     * @Route("/add_forma",name="add_forma")
     */
    public function addform(Request $request, EntityManagerInterface $em, EntrepriseRepository $user_rep)
    {

        $user = $this->getUser();
        $formation = new Formation();

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation->setBackcolor("#cc66ff");
            $formation->setBordercolor("#440066");
            $formation->setTextcolor("#ffffff");
            $formation->setStatus("1");
            $formation->addIdUser($user);

            $image = $form->get('image')->getData();
            $nomImage = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move($this->getParameter('uploads_directory'), $nomImage);
            $formation->setImage($nomImage);
            $formation->setUpdatedAt(new \DateTime('now'));
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute("listforma");
        }
        return $this->render('formation/add_form.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/listforma/{id}", name="forma")
     */
    public function aff_form($id, FormationRepository $repository): Response
    {
        $formation = $repository->find($id);
        return $this->render('formation/affforma.html.twig', [
            'formation' => $formation
        ]);
    }


    /**
     * @Route("/formation/supp/{id}", name="formation_suppression")
     */
    public function supprimerforma($id, FormationRepository $repository)
    {
        $formation = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($formation);
        $em->flush();
        return $this->redirectToRoute("listforma");


    }

    /**
     * @Route("/formation/modif/{id}", name="forma_modif", methods="GET|POST")
     */
    public function edit(Request $request, Formation $formation, EntrepriseRepository $user_rep): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation->setBackcolor("#cc66ff");
            $formation->setBordercolor("#440066");
            $formation->setBordercolor("#ffffff");
            $formation->setStatus("1");
            $formation->addIdUser($user);
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('uploads_directory'), $filename);
            $formation->setImage($filename);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('listforma');
        }

        return $this->render('formation/modification.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route("/listefo/{id}",name="listformabycat")
     */
    function listFormationByCat(CategorieRepository $repcat, FormationRepository $repform, $id)
    {
        $categorie = $repcat->find($id);
        $formations = $repform->listFormationByCat($categorie->getId());
        return $this->render('formation/catparforma.html.twig', [
            'c' => $categorie,
            'formations' => $formations
        ]);

    }


    /**
     * @Route("/mylist", name="mylist")
     */
    public function mylistaff(FormationRepository $repository, EntrepriseRepository $user_rep): Response
    {
        $user = $this->getUser();
        $id = $user->getUsername();
        $formations = $repository->findAll();
        return $this->render('formation/mylist.html.twig', [

            'formations' => $formations,
            'id' => $id
        ]);
    }

    /**
     * @Route("/formation/{id}/like", name="forma_like")
     *
     * @param \App\Entity\Formation $formation
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \App\Repository\FormationLikeRepository $dislikerepo
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function like(Formation $formation, EntityManagerInterface $em, FormationLikeRepository $likerepo): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);


        if ($formation->islikedbyUser($user)) {
            $like = $likerepo->findOneBy([
                'formation' => $formation,
                'user' => $user
            ]);

            $em->remove($like);
            $em->flush();


            return $this->json([
                'code' => 200,
                'message' => "like bien supprimé",
                'likes' => $likerepo->count(['formation' => $formation])
            ], 200);

        }

        $like = new FormationLike();
        $like->setFormation($formation)
            ->setUser($user);

        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => "like bien ajouté",
            'likes' => $likerepo->count(['formation' => $formation])
        ], 200);
    }


    /**
     * @Route("/formation/{id}/dislike", name="forma_dislike")
     *
     * @param \App\Entity\Formation $formation
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \App\Repository\FormationDislikeRepository $dislikerepo
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function dislike(Formation $formation, EntityManagerInterface $em, FormationDislikeRepository $dislikerepo): Response
    {
        $user = $this->getUser();
        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);

        if ($formation->isdislikedbyUser($user)) {
            $dislike = $dislikerepo->findOneBy([
                'formation' => $formation,
                'user' => $user
            ]);

            $em->remove($dislike);
            $em->flush();


            return $this->json([
                'code' => 200,
                'message' => "dislike bien supprimé",
                'dislikes' => $dislikerepo->count(['formation' => $formation])
            ], 200);

        }

        $dislike = new FormationDislike();
        $dislike->setFormation($formation)
            ->setUser($user);

        $em->persist($dislike);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => "dislike bien ajouté",
            'dislikes' => $dislikerepo->count(['formation' => $formation])
        ], 200);
    }


    /**
     * @Route("/success", name="success")
     */
    public function sucess(): Response
    {

        return $this->render('formation/success.html.twig', [

        ]);
    }


    /**
     * @Route("/error", name="error")
     */
    public function error(): Response
    {

        return $this->render('formation/error.html.twig', [

        ]);
    }

    /**
     * @Route("/formation/create-checkout-session/{id}", name="checkout")
     */
    public function checkout(FormationRepository $repository , $id)

    {
        \Stripe\Stripe::setApiKey('sk_test_51IXnu2Ia1QXbZEIfeNS1cTsRP29IZawAtsrPFbAqg0HYa90Uog5vEvYMx4u6blLzlknmJMwAvkTOS8z6msvp2Usn00EfPsgyeX');

        $formation= $repository->findOneBy(['id'=> $id]);
        $prix=$formation->getPrix();
        $image=$formation->getImage();
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $formation->getNom(),
                        'images' => [$image],
                    ],
                    'unit_amount' => $prix.='00',

                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('error', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        return new JsonResponse(['id' => $session->id]);

    }

    /**
     * @Route("/admindash/searchOffreajax ", name="ajaxsearch")
     */
    public function searchOffreajax(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Formation::class);
        $requestString=$request->get('searchValue');
        $formations = $repository->ajax($requestString);

        return $this->render('formation/ajax.html.twig', [
            "formations"=>$formations
        ]);
    }


}