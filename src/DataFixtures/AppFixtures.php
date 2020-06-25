<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;



class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitre("Titre de l'article N: $i")
                     ->setContent("<p>Content de l'article N: $i </p>")
                     ->setImage("https://via.placeholder.com/350x150/0000FF/FFFFFFC")
                     ->setCreatedAt(new \DateTime());
            $manager->persist($article);
        }

        $manager->flush();
    }
}
