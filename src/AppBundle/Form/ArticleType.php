<?php

namespace AppBundle\Form;

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
            //->add('image')
            ->add('author', EntityType::class, array(
                'label' => 'Auteur',
                'class' => 'AppBundle\Entity\Author',
                'choice_label' => 'fullName',
                'placeholder' => 'Choisissez un auteur'
            ))
            //->add('tags')
            ->add('Enregistrer',SubmitType::class)
            ->add('Annuler',ResetType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }
}
