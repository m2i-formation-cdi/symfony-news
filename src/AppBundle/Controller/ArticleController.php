<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\AbstractFrontEndController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class ArticleController
 * @package AppBundle\Controller
 *
 * @Route("article")
 */

class ArticleController extends AbstractFrontEndController
{
    /**
     * @Route("/page/{page}", name="article_list", defaults={"page": 1})
     * @param $page
     * @return Response
     */
    public function indexAction($page)
    {
        $articlesPerPage = 5;

        $articleRepository= $this->getDoctrine()->getRepository('AppBundle:Article');

        $nbOfArticles = $articleRepository->getTotalNumberOfArticles();
        $nbOfPages =  ceil($nbOfArticles / $articlesPerPage);


        $params = $this->getAsideData();
        $params['allArticles'] = $articleRepository->getArticlesByPage($articlesPerPage, $page);
        $params['nbOfPages'] = $nbOfPages;
        $params['nbOfArticles'] = $nbOfArticles;
        $params['currentPage'] = $page;

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/by-title/{slug}", name="article_details", requirements={"slug": "[a-zA-Z1-9\-_\/]+"})
     * @return Response
     */
    public function detailsAction(Request $request, $slug)
    {
        //Récupération de l'article
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
        $article = $articleRepository->findOneBySlug($slug);

        /*// Instanciation de Comment
        // et initialisation de l'association avec l'article
        // de façon à insérer un commentaire sur un article particulier
        $comment = new Comment();
        $comment->setArticle($article);

        //Création du formulaire
        $form = $this->createForm(CommentType::class,
            $comment,
            array(
                'action' => $this->generateUrl('article_details', array('slug' => $slug))
            )
        );

        // Hydratation du formulaire avec la requête
        $form->handleRequest($request);

        // Traitement du formulaire
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            //Redirection pour Réinitialiser le formulaire
            return $this->redirectToRoute('article_details', array('slug' => $slug));

        }*/

        $formHandler = $this->get('app.formhandler.comment');
        $formHandler->setArticle($article);


        if($formHandler->process()){
            return $this->redirectToRoute('article_details', array('slug' => $slug));
        }

        $form = $formHandler->getForm();

        //Paramètres passés à la vue
        $params = $this->getAsideData();
        $params['article'] = $article;
        $params['commentForm'] = $form->createView();

        return $this->render('article/details.html.twig', $params);
    }

    /**
     * @Route("/by-tag/{tag}", name="article_by_tag")
     * @param $tag
     * @return Response
     */
    public function showByTagAction($tag){
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');

        $params = $this->getAsideData();
        $params['allArticles'] = $articleRepository->getArticleByTag($tag);
        $params['queryTitle'] = "par tag : $tag";

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/by-year/{year}", name="article_by_year",
     * requirements={"year": "\d{4}"}
     * )
     * @param $year
     * @return Response
     */
    public function showByYearAction($year){
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');

        $params = $this->getAsideData();
        $params['allArticles'] = $articleRepository->getArticleByYear($year);
        $params['queryTitle'] = "par année : $year";

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/by-author/{id}", name="article_by_author",
     * requirements={"id": "\d+"}
     * )
     * @param $id
     * @return Response
     */
    public function showByAuyhorAction($id){
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
        $authorRepository = $this->getDoctrine()->getRepository('AppBundle:Author');

        $author = $authorRepository->find($id);

        $params = $this->getAsideData();
        $params['allArticles'] = $articleRepository->getArticleByAuthor($id);
        $params['queryTitle'] = "par auteur : ".$author->getFullName();

        return $this->render('article/index.html.twig', $params);
    }


}
