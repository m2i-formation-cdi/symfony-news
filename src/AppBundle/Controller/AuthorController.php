<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Author;
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
