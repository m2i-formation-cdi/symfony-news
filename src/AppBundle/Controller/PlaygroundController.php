<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class PlaygroundController
 * @package AppBundle\Controller
 *
 * @Route("playground")
 */
class PlaygroundController extends Controller
{
    /**
     * @return Response
     * @Route("/author")
     */
    public function testAuthorAction()
    {

        //Suppression de tous les auteurs
        $this->deleteAllAuthors();

        // Ajout des auteur
        $this->addAuthor(array(
           'firstName'  => 'Pierre',
            'name'      => 'Legrand',
            'email'     => 'plegrand@gmail.com',
            'password'  => 'test'
        ));

        $this->addAuthor(array(
            'firstName'  => 'Pierre',
            'name'      => 'Haski',
            'email'     => 'phaski@gmail.com',
            'password'  => 'test'
        ));

        $this->addAuthor(array(
            'firstName'  => 'Paul Emile',
            'name'      => 'Victor',
            'email'     => 'pvictor@gmail.com',
            'password'  => 'test'
        ));



        //Récupération de tous les auteurs
        $repo = $this->getAuthorRepository();
        $authors = $repo->findAll();

        $author = $repo->findBy(array('email' => 'plegrand@gmail.com'));

        return $this->render('playground/author-playground.html.twig',
            array('authors' => $authors, 'author' => $author)

        );
    }

    private function deleteAllAuthors(){
        $repo = $this->getAuthorRepository();
        $authors = $repo->findAll();

        $em = $this->getDoctrineManager();

        foreach($authors as $author){
            $em->remove($author);
        }

        $em->flush();
    }

    private function addAuthor(array $data){

        // Recherche d'un auteur correspondant dans la base
        $repo = $this->getAuthorRepository();
        $authors = $repo->findBy(array('email'=>$data['email']));

        // Création d'un nouvel auteur uniquement
        // si celui-ci est absent dans la base
        if(count($authors) == 0){
            $author = new Author();
            $author ->setFirstName($data['firstName'])
                ->setName($data['name'])
                ->setEmail($data['email'])
                ->setPassword(sha1($data['password']));

            $em = $this->getDoctrineManager();

            $em->persist($author);

            $em->flush();
        }
    }

    /**
     * @return EntityManager
     */
    private function getDoctrineManager(){
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getAuthorRepository(){
        return $this->getDoctrine()->getRepository('AppBundle:Author');
    }
}
