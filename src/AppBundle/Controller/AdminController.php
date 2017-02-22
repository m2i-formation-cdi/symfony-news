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
        $authorRepository = $this->getDoctrine()->getRepository('AppBundle:Author');
        $authors = $authorRepository->getAuthorList();

        return $this->render('admin/index.html.twig', array('authors' => $authors));
    }
}
