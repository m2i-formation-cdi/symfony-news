<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use AppBundle\Form\AuthorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
        $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
        $articles = $articleRepository->getArticleByAuthor($this->getUser()->getId());

        return $this->render('author/index.html.twig',
            array('articles' => $articles)
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
     * @Route("/article/new", name="article_new")
     * @Route("/article/edit/{id}", name="article_edit")
     *
     * @Security("has_role('ROLE_AUTHOR')")
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function addEditAction(Request $request, $id = null)
    {
        // Récupération ou instanciation d'une entité Article
        // selon que l'on est en mode création ou modification
        if($id == null){
            $article = new Article();
            // L'auteur de l'article est l'utilisateur identifié
            $article->setAuthor($this->getUser());
            //action du formulaire
            $postUrl = $this->generateUrl('article_new');
        } else {
            $articleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
            $article = $articleRepository->find($id);
            //action du formulaire
            $postUrl = $this->generateUrl('article_edit', array('id' => $id));
        }

        // Création du formulaire
        $form = $this->createForm(ArticleType::class, $article,
            array('action' => $postUrl)
        );

        //var_dump($form->get('image')->get('uploadedFile'));


        /*if($form->get('image')->get('uploadedFile') == null || $form->get('image')->get('toBeDeleted')){
            $form->remove('image');
            var_dump($form->get('image'));
        }*/

        //var_dump($form->getData());

        // Hydratation du formulaire avec la requête
        $form->handleRequest($request);

        // Traitement du formulaire
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();

            //Attribution du chemin de base à l'entité Image dans Article
            if($article->hasImage()){
                $basePath = $this->get('kernel')->getRootDir();
                $basePath = $basePath. '/../web/img/photos';
                $article->getImage()->setBasePath($basePath);

                //Suppression de l'image
                if($article->getImage()->toBeDeleted() || $article->getImage()->mustBeDeleted()){
                    $article->setImage(null);
                }
            }


            // Persistence de l'entité Article et éventuellement
            // de l'entité Image associée
            $em->persist($article);
            $em->flush();

            // Upload manuel pour gérer la modification de l'image
            // lorsque l'entité Image n'a pas changé
            if($article->hasImage()) {
                $article->getImage()->upload();
            }

            //Message Flash de confirmation
            $this->addFlash('info','Votre article est enregistré dans la base de données');

            return $this->redirectToRoute('author_home');
        }

        return $this->render('article/form.html.twig',
            array('articleForm' => $form->createView())
        );
    }
}
