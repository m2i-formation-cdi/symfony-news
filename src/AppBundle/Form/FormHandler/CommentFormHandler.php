<?php

namespace AppBundle\Form\FormHandler;

use AppBundle\Entity\Article;

class CommentFormHandler extends GenericFormHandler
{

    public function setArticle(Article $article){
        $this->form->get('article')->setData($article);
    }

}