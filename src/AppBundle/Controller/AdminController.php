<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController
 * @package AppBundle\Controller
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_home")
     * @return Response
     *
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
 * @Route("/new-author", name="author_new")
 * @return Response
 */
    public function newAction()
    {
        return $this->render('article/form.html.twig');
    }
}
