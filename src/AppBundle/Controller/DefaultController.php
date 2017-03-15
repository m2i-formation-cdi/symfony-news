<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/test")
     * @return Response
     */
    public function testAction(){
        $dataProvider = $this->get('data_provider');
        $data = $dataProvider->getAllArticles();
        return $this->render('default/test.html.twig', array('data' => $data));
    }

    /**
     * @Route("/login-admin", name="admin_login")
     * @Route("/login-author", name="author_login")
     */
    public function loginAction(Request $request){

        $securityUtils = $this->get('security.authentication_utils');
        $userName = $securityUtils->getLastUsername();
        $error = $securityUtils->getLastAuthenticationError();

        $currentRoute = $request->attributes->get('_route');
        if($currentRoute == 'author_login'){
            $formTitle = 'Auteurs';
            $checkRoute = 'author_login_check';
        } else {
            $formTitle = 'Administrateur';
            $checkRoute = 'admin_login_check';
        }

        return $this->render('default/login.html.twig', [
            'formTitle' => $formTitle,
            'checkRoute' => $checkRoute,
            'userName' => $userName,
            'error' => $error
        ]);
    }


}
