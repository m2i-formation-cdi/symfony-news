<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
use AppBundle\Form\AuthorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/author/new", name="author_new")
     * @param Request $request
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
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('admin_home');
        }

        //Affichage du formulaire
        return $this->render('author/form.html.twig', array('authorForm' => $form->createView()));
    }
}
