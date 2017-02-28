<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Author;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class AuthorFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

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
                ->setName($faker->name)
                ->setEmail($faker->email)
                ->setPlainPassword('pass');

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