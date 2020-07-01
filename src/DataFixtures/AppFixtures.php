<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker= Factory::create('FR_fr');
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 5; $i++) {
            $category= new Category();
            $category->setTitle($this->faker->sentence())
                     ->setDescription($this->faker->paragraph());

            $manager->persist($category);

            for ($j = 1; $j <= mt_rand(6,8); $j++) {
                $article=new Article();
                $content='<p>'.join((array)$this->faker->paragraph(5),'</p><p>').'</p>';
                $article->setTitre($this->faker->sentence());
                $article->setCategory($category);
                $article->setContent($content);
                $article->setImage($this->faker->imageUrl());
                $article->setCreatedAt($this->faker->dateTimeBetween('-2 weeks'));

                $manager->persist($article);

                for ($k = 1; $k <= 10; $k++) {
                    $comment= new Comment();
                    $content='<p>'.join((array)$this->faker->paragraph(2),'</p><p>').'</p>';
                    $days= (new \DateTime())->diff($article->getCreatedAt
                    ())->days;
                    $comment->setAuthor($this->faker->name());
                    $comment->setContent($content);
                    $comment->setCreatedAt($this->faker->dateTimeBetween('-'.$days.'days'));
                    $comment->setArticle($article);

                    $manager->persist($comment);
                }
            }

        }


//        for ($i = 1; $i <= 10; $i++) {
//            $article = new Article();
//            $article->setTitre("Titre de l'article N: $i")
//                     ->setContent("<p>Content de l'article N: $i </p>")
//                     ->setImage("https://via.placeholder.com/350x150/0000FF/FFFFFFC")
//                     ->setCreatedAt(new \DateTime());
//            $manager->persist($article);
//        }

     $manager->flush();
    }
}
