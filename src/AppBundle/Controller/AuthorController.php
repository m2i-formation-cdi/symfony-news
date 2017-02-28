<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Author;
use AppBundle\Form\ArticleType;
use AppBundle\Form\AuthorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuteurController
 * @package AppBundle\Controller
 *
 * @Route("author")
 */
class AuthorController extends Controller
{
    /**
     * @Route("/", name="author_home")
     * @return Response
     */
    public function indexAction()
    {
        $author = $this->getUser();

        $articles = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->findByAuthor($author);

        return $this->render('author/index.html.twig',
            [
                'author' => $author,
                'articles' => $articles
            ]
        );
    }

    /**
     * @return Response
     * @Route("/new-article", name="author_new_article")
     * @Route("/edit-article/{id}", name="author_update_article")
     */
    public function newArticleAction(Request $request, $id=null){

        $test= null;
        $articleRepository = $this->getDoctrine()
            ->getRepository('AppBundle:Article');

        if($id == null){
            $article = new Article();
            $article->setAuthor($this->getUser());
            $action = $this->generateUrl('author_new_article');
        } else {
            $article = $articleRepository->find($id);
            $action = $this->generateUrl('author_update_article', ['id'=>$id]);
        }


        $form = $this->createForm(
            ArticleType::class,
            $article,
            [
                'action' => $action
            ]
        );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $doPersist = true;

            $test = $articleRepository->findOneByTitle($article->getTitle());


            if( $test != null && $article->getId() != $test->getId()){
                $doPersist = false;
            }

            if($doPersist){

                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirectToRoute('author_home');

            } else {
                $this->addFlash('warning', 'Il existe déjà un article avec ce titre');
            }

        }

        return $this->render(
            'author/article_form.html.twig',
            ['articleForm'=>$form->createView(), 'article' => $article, 'test'=>$test]
        );
    }

    /**
     * @Route("/edit/{id}", name="author_edit")
     * @param int $id
     * @return Response
     */
    public function editAction($id = null)
    {
        return $this->render('author/form.html.twig');
    }

    /**
     * @Route("/new", name="author_new")
     * @return Response
     */
    public function newAction(Request $request)
    {
        $author = new Author();

        //Création d'un nouveau formulaire
        $form = $this->createForm(AuthorType::class,
            $author,
            array(
                'action' => $this->generateUrl('author_new')
            )
        );

        //Hydratation du formulaire avec les données de la requête
        $form->handleRequest($request);

        //Traitement du formulaire s'il est valide
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }

        //Affichage du formulaire
        return $this->render('author/form.html.twig', array('authorForm' => $form->createView()));
    }
}
