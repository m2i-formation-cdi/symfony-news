<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Author;
use AppBundle\Entity\Article;
use AppBundle\Entity\Image;
use AppBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class CommentFixture extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $nbFixtures = 25;

        $comments = array();

        for($i=0 ; $i < $nbFixtures; $i++){
            $article = $this->getReference('article_'.$i);
            $nbComments = mt_rand(0,10);

            for($k=1; $k <=$nbComments; $k++){
                $comments[$i*$k] = new Comment();
                $comments[$i*$k]->setArticle($article)
                                ->setAuthor($faker->email)
                                ->setCreatedAt($faker->dateTimeThisDecade)
                                ->setText($faker->text(200));
                $manager->persist($comments[$i*$k]);
            }
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 5;
    }
}