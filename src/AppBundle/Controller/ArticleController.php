<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Controller\AbstractFrontEndController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ArticleController
 * @package AppBundle\Controller
 *
 * @Route("article")
 */

class ArticleController extends AbstractFrontEndController
{
    /**
     * @Route("/", name="article_list")
     * @return Response
     */
    public function indexAction()
    {
        $dataProvider = $this->getDataProvider();

        $params = $this->getAsideData();
        $params['allArticles'] = $dataProvider->getAllArticles();

        return $this->render('article/index.html.twig', $params);
    }

    /**
     * @Route("/{id}", name="article_details")
     * @return Response
     */
    public function detailsAction()
    {
        $dataProvider = $this->getDataProvider();

        $params = $this->getAsideData();
        $params['article'] = $dataProvider->getOneArticle();

        return $this->render('article/details.html.twig', $params);
    }

    /**
     * @Route("/new", name="article_new")
     * @Route("/edit/{id}", name="article_edit")
     * @param int $id
     * @return Response
     */
    public function addEditAction($id = null)
    {
        return $this->render('article/form.html.twig');
    }


}
