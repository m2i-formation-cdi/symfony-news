<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\AbstractFrontEndController;

class DefaultController extends AbstractFrontEndController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        //$dataProvider = $this->getDataProvider();
        $ArticleRepository = $this->getDoctrine()->getRepository('AppBundle:Article');
        $lastArticles = $ArticleRepository->getLastArticles(4);

        $params = $this->getAsideData();
        $params['lastArticles'] = $lastArticles;

        return $this->render(
            'default/index.html.twig',
            $params
        );
    }

    /**
     * @Route("/about", name="about_page")
     * @return Response
     */
    public function aboutAction(){
        return $this->render(
            'static/about.html.twig',
            $this->getAsideData()
        );
    }

    /**
     * @Route("/login/admin", name="admin_login")
     * @return Response
     */
    public function adminLoginAction(){

        $securityUtils = $this->get('security.authentication_utils');
        //Dernier utilisateur saisi
        $lastUserName = $securityUtils->getLastUsername();
        //Erreurs éventuelles
        $error = $securityUtils->getLastAuthenticationError();

        return $this->render(
            'default/admin-login.html.twig',
            array(
                'userName'  => $lastUserName,
                'error'     => $error
            )
        );
    }

    /**
     * @Route("/test")
     * @return Response
     */
    public function testAction(){
        $dataProvider = $this->get('data_provider');
        $data = $dataProvider->getAllArticles();
        return $this->render('default/test.html.twig', array('data' => $data));
    }


}
