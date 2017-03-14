<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return $this->render('author/index.html.twig');
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
    public function newAction()
    {
        return $this->render('article/form.html.twig');
    }

    /**
     * @Route("/article-new", name="article_new")
     * @Route("/article-edit/{id}", name="article_edit")
     * @param int $id
     * @return Response
     */
    public function addEditAction($id = null)
    {
        return $this->render('article/form.html.twig');
    }
}
