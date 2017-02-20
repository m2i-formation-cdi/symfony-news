<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Tag;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;


class TagFixture extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $tagList = array(   'PHP', 'Photographie', 'Java',
                            'Symfony', 'Javascript', 'Cordova',
                            'Art', 'Politique', 'Sport', 'Divers');
        $nbFixtures = count($tagList);

        $tags = array();
        for($i=0 ; $i < $nbFixtures; $i++){
            $tags[$i] = new Tag();
            $tags[$i]->setTagName($tagList[$i]);

            $manager->persist($tags[$i]);

            $this->addReference('tag_'.$i, $tags[$i]);
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
        return 2;
    }
}