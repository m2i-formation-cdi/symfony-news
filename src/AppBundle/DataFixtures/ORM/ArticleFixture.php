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

class ArticleFixture extends AbstractFixture implements OrderedFixtureInterface
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



        $articles = array();
        for($i=0 ; $i < $nbFixtures; $i++){
            $articles[$i] = new Article();
            $articles[$i]->setTitle($faker->text(50))
                ->setLead($faker->text(200))
                ->setText($faker->text(1500))
                ->setCreatedAt($faker->dateTimeThisDecade)
                ->setAuthor(
                  $this->getReference('author_'.mt_rand(0,4))
                );

            //Ajout de l'image
            $articles[$i]->setImage($this->getReference('image_'.$i));

            //Ajout de tags
            $nbTags = mt_rand(1, 5);
            $pickedTags = array();
            for($k=1; $k <= $nbTags; $k++){
                $picked = false;
                while(!$picked){
                    $n = mt_rand(0,9);
                    if(! in_array($n,$pickedTags)){
                        $picked = true;
                        array_push($pickedTags, $n);
                        $articles[$i]->addTag(
                          $this->getReference('tag_'.$n)
                        );
                    }
                }
            }

            $manager->persist($articles[$i]);

            $this->addReference('article_'.$i, $articles[$i]);
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
        return 4;
    }
}