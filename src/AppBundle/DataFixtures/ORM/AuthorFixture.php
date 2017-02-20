<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Author;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AuthorFixture extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        $nbFixtures = 5;

        $authors = array();
        for($i=0 ; $i < $nbFixtures; $i++){
            $authors[$i] = new Author();
            $authors[$i]->setFirstName($faker->firstName)
                ->setName($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword(sha1('pass'));

            $manager->persist($authors[$i]);

            $this->addReference('author_'.$i, $authors[$i]);
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
        return 1;
    }
}