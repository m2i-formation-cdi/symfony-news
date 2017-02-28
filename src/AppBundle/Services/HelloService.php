<?php


namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;

class HelloService
{

    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var string
     */
    private $messageRecipient;

    /**
     * HelloService constructor.
     * @param $who
     */
    public function __construct(EntityManager $em, \Swift_Mailer $mailer, $recipient)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->messageRecipient = $recipient;
    }

    public function sayHello($id){
        $repository = $this->em->getRepository('AppBundle:Author');
        $author = $repository->find($id);

        if($author == null){
            $who = "world";
        }else {
            $who = $author->getFullName();
        }

        return "Hello ". $who;
    }

    public function notify(){
        $message = \Swift_Message::newInstance();
        $message->setTo($this->messageRecipient)
                ->setFrom('site@mail.com')
                ->setSubject('va crever')
                ->setBody('Un article a été ajouté');


        $this->mailer->send($message);
    }



}