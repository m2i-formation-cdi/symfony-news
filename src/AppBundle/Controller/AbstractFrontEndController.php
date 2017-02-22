<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Services\FakeDataProvider;

abstract class AbstractFrontEndController extends Controller
{
    /**
     * @return FakeDataProvider
     */
    protected function getDataProvider(){
        return $this->get('data_provider');
    }

    protected function getAsideData(){

        $tagRepository= $this->getDoctrine()->getRepository('AppBundle:Tag');
        $tags = $tagRepository->getTagList();

        $articleRepository= $this->getDoctrine()->getRepository('AppBundle:Article');
        $archives = $articleRepository->getArchive();
        $authors = $articleRepository->getAuthorListForAside();

        $commentRepository = $this->getDoctrine()->getRepository('AppBundle:Comment');
        $lastComments = $commentRepository->getLastComments(5);

        $popularArticles = $articleRepository->getMostPopularArticles(3);

        return array(
            'tags'    => $tags,
            'archives' => $archives,
            'authors' => $authors,
            'popularArticles'=> $popularArticles,
            'lastComments'=> $lastComments
        );
    }
}
