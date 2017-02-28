<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Author;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Image;
use AppBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DateTime;

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
     * @Route("/article")
     * @return Response
     */
    public function testArticleAction(){
        $authorRepo = $this->getAuthorRepository();
        $author = $authorRepo->findOneBy(array('email' =>'plegrand@gmail.com'));

        $image = new Image();
        $image->setFileName('img02.jpg')
            ->setLegend('ma belle image')
            ->setCredit('mon oeuvre à moi');

        $article = new Article();
        $article->setAuthor($author)
            ->setTitle('Mon premier article')
            ->setLead('bla bla')
            ->setText('lorem ipsum')
            ->setCreatedAt(new DateTime('today'))
            ->setImage($image);

        $tag = new Tag();
        $tag->setTagName('Java');
        $article->addTag($tag);

        $tag = new Tag();
        $tag->setTagName('Hibernate');
        $article->addTag($tag);


        //Persistence de l'article
        $em = $this->getDoctrineManager();

        $em->persist($article);

        $em->flush();


        $articleRepo = $this->getDoctrine()->getRepository('AppBundle:Article');
        $articles = $articleRepo->findAll();


        return $this->render('playground/article-playground.html.twig',
            array('articles' => $articles)

        );
    }

    /**
     * @Route("/query")
     */
    public function testQueries(){
        $tagRepository= $this->getDoctrine()->getRepository('AppBundle:Tag');
        $data = $tagRepository->getTagList();

        $articleRepository= $this->getDoctrine()->getRepository('AppBundle:Article');
        $data = $articleRepository->getArchive();

        //$authorRepository = $this->getDoctrine()->getRepository('AppBundle:Author');
        $data = $articleRepository->getAuthorListForAside();
        $data = $articleRepository->getMostPopularArticles(20);

        return $this->render('playground/query-playground.html.twig',
            array('data' => $data)
        );
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

    /**
     * @Route("/sendmail")
     */
    public function sendMail(){
        $message = \Swift_Message::newInstance()
            ->setSubject('test')
            ->setFrom('moi@moi.com')
            ->setTo('lui@lui.com')
            ->setBody('Un test');

        $this->get('mailer')->send($message);

        return $this->render('playground/sendmail.html.twig');
    }

    /**
     * @return Response
     * @Route("/")
     */
    public function indexAction(){

        $helloService = $this->get('app.hello');
        $message = $helloService->sayHello(4);

        $helloService->notify();

        return $this->render('playground/index.html.twig',
        ['message' => $message]
        );
    }
}
