<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Image;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;


class ImageFixture extends AbstractFixture implements OrderedFixtureInterface
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

        $images = array();
        for($i=0 ; $i < $nbFixtures; $i++){
            $fileName = 'img'.str_pad(($i+1), 2, '0', STR_PAD_LEFT).'.jpg';
            $images[$i] = new Image();
            $images[$i] ->setFileName($fileName)
                        ->setLegend($faker->text(120))
                        ->setCredit($faker->name);

            $manager->persist($images[$i]);

            $this->addReference('image_'.$i, $images[$i]);
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
        return 3;
    }
}