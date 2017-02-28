<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\DataTransformer\EntityToIntDataTransformer;

class CommentType extends AbstractType
{

    private $articleTransformer;

    /**
     * CommentType constructor.
     * @param $articleTransformer
     */
    public function __construct(EntityToIntDataTransformer $articleTransformer)
    {
        $this->articleTransformer = $articleTransformer;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', EmailType::class, array('label' => 'e-mail', 'required' => true))
            ->add('text', TextareaType::class, array('label' => 'message', 'required' => true,))
            ->add('article',HiddenType::class)
            ->add('Enregistrer', SubmitType::class)
            ->add('Annuler', ResetType::class)
        ;

        $builder->get('article')->addModelTransformer($this->articleTransformer);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comment'
        ));
    }

    /*
    public function getName()
    {
        return "comment_type";
    }*/
}
