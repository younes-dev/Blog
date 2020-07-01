<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $faker;

    public function __construct()
    {
        $this->faker= Factory::create('FR_fr');
    }

    /**
     * @Route("/blog", name="blog")
     * @param ArticleRepository $repo
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(ArticleRepository $repo, Request $request, PaginatorInterface $paginator)
    {
        $articles=$repo->findAll();
        $articles = $paginator->paginate(
            $articles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
//        echo $this->faker->name."</br>";
//        echo nl2br("\n".$this->faker->name."\n");
//        echo nl2br($this->faker->name."\n");
//        echo nl2br($this->faker->email."\n");
//        echo "One line after another line"."</br>";
//        //echo "</br>";
//        echo "One line after another line";
//        dump('here we go');die;

        return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("/blog/{id}", name="blog_show", requirements={"id"="\d+"})
     * By passing the class in function parameters
     * we use param converter who do the job and retrive the article by id
     * @param Article $article
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Article $article /*Int $id,ArticleRepository $repo*/,Request $request,ObjectManager $manager)
    {
        $comment=new Comment();
        $form= $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $comment->setCreatedAt(new \DateTime());
            $comment->setArticle($article);
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('blog_show',[
                'id' => $article->getId()
            ]);
        }

        //$article=$repo->find($id);
        return $this->render('blog/show.html.twig',[
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("blog/new",name="blog_new", methods={"POST","GET"})
     * @Route("blog/{id}/edit",name="blog_edit", methods={"POST","GET"})
     * @param Article $article
     * @param Request $request
     * @param ObjectManager $manager
     * @return string
     */
    public function Form(Article $article=Null, Request $request, ObjectManager $manager)
    {
        $article =((!$article) ? (new Article()) : $article);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render("blog/create.html.twig", [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() ? $article->getId() : null
        ]);
    }







//*******************************************************
//*****     Create Form Via CreateFormBuilder    ********
//*******************************************************
//            $form=$this->createFormBuilder($article)
//                        ->add('titre')
//                        ->add('content')
//                        ->add('image')
//                        ->getForm();
//*******************************************************


}
