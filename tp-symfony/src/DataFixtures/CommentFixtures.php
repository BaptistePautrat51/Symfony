<?php

namespace App\DataFixtures;

use App\Entity\Comment;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
{

    $faker = Factory::create('fr_FR');
    for ($i = 0; $i < 10; $i++){
        for($j = 0; $j < 2; $j++) {
            $comment = new Comment();
            $comment->setName($faker->userName);
            $comment->setEmail($faker->email);
            $comment->setCreatedAt($faker->dateTime);
            $comment->setComment($faker->realText());
            $comment->setArticle($this->getReference(AppFixtures::ARTICLE_REFERENCE . $i));
            $manager->persist($comment);
        }
    }
    $manager->flush();
}

    public function getDependencies()
{
    return [
        AppFixtures::class,
    ];
}
}
