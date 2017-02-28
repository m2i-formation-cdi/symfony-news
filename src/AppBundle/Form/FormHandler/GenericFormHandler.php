<?php


namespace AppBundle\Form\FormHandler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManager;

class GenericFormHandler
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * GenericFormHandler constructor.
     * @param Form $form
     * @param Request $request
     * @param EntityManager $em
     */
    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em = $em;
    }

    public function process(){
        $success = false;

        $this->form->handleRequest($this->request);

        if($this->form->isValid()){
            $success = true;
            $this->onSuccess();
        }

        return $success;
    }

    public function getForm(){
        return $this->form;
    }

    private function onSuccess(){
        $this->em->persist($this->form->getData());
        $this->em->flush();
    }


}