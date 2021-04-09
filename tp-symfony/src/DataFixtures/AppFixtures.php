<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;




class AppFixtures extends Fixture
{

    public const ARTICLE_REFERENCE = 'article-ref';
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setAuthor($faker->name);
            $article->setSubtitle($faker->realText(100));
            $article->setBody($faker->realText(5000));
            $article->setCreatedAt($faker->dateTime);
            $article->setImage($faker->imageUrl());
            $article->setTitle($faker->realText(100));
            $manager->persist($article);

            $this->addReference(self::ARTICLE_REFERENCE.$i, $article);
        }
        $manager->flush();
    }
}




