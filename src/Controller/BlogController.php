<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        $articles=$repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig');
    }

    /**
     * @Route("/blog/{id}", name="blog_show", requirements={"id"="\d+"})
     * By passing the class in function parameters
     * we use param converter who do the job and retrive the article by id
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Article $article /*Int $id,ArticleRepository $repo*/)
    {
        //$article=$repo->find($id);
        return $this->render('blog/show.html.twig',[
            'article' => $article
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
