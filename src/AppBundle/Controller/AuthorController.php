<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
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
        $articleRepository = $this->getDoctrine()
            ->getRepository('AppBundle:Article');
        $articles = $articleRepository->findByAuthor($author);

        return $this->render(
            'author/index.html.twig',
            ['articles' => $articles]
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
     * @Route("/article-new", name="article_new")
     * @Route("/article-edit/{id}", name="article_edit")
     * @param int $id
     * @return Response
     */
    public function addEditArticleAction($id = null, Request $request)
    {
        if($id == null){
            //Récupération de l'auteur authentifié
            $author = $this->getUser();
            //Création de l'entité
            $article = new Article();
            //Liaison de l'article avec l'auteur
            $article->setAuthor($author);
            $action = $this->generateUrl('article_new');

        } else {
            $articleRepository = $this->getDoctrine()
                ->getRepository('AppBundle:Article');
            $article = $articleRepository->find($id);

            $action = $this->generateUrl('article_edit', ['id' => $id]);
        }

        //Création du formulaire
        $form = $this->createForm(
            ArticleType::class,
            $article,
            [
                'action' => $action
            ]
        );

        //Traitement du formulaire
        $form->handleRequest($request);

        //Persistence de l'entité si le formulaire est valide
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('author_home');
        }

        return $this->render('article/form.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }
}
