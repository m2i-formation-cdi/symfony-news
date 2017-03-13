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

        $params = $this->getAsideData();
        $params['lastArticles'] = $this->getDoctrine()
            ->getRepository('AppBundle:Article')
            ->getRecentArticles(4);

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


}
