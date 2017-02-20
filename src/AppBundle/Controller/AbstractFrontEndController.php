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
        $dataProvider = $this->getDataProvider();
        $tags = $dataProvider->getTags();
        $archives = $dataProvider->getArchive();
        $authors = $dataProvider->getAllAuthors();
        $lastComments = $dataProvider->getAllComments();
        $popularArticles = $dataProvider->getAllArticles();

        return array(
            'tags'    => $tags,
            'archives' => $archives,
            'authors' => $authors,
            'popularArticles'=> $popularArticles,
            'lastComments'=> $lastComments
        );
    }
}
