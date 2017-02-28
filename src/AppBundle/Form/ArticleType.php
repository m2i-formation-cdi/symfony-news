<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\TagsDataTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Titre'))
            ->add('lead', TextareaType::class, array(
                'label' => 'Chapô',
                'attr' => array('rows' => 6)
            ))
            ->add('text', TextareaType::class, array(
                'label' => 'Texte',
                'attr' => array('rows' => 12)
            ))
            ->add('tags', TextType::class, array('label' => 'Tags'))
            ->add('image', ImageType::class, array('required' => false))
            ->add('Enregistrer',SubmitType::class)
            ->add('Annuler',ResetType::class)
        ;

        $builder->get('tags')->addModelTransformer(new TagsDataTransformer($this->entityManager));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article',
        ));
    }
}
