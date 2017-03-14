<?php

namespace AppBundle\Form;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('lead', TextareaType::class, [
                'label' => 'chapô',
                'attr' => ['rows' => 6]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'texte',
                    'attr' => ['rows' => 12]
            ])
            //->add('image')
            ->add('author', EntityType::class, [
                'class' => 'AppBundle\Entity\Author',
                'label' => 'Auteur',
                'placeholder' => 'Choisissez un auteur',
                'choice_label' => 'fullName',
                'multiple' => false,
                'expanded' => true
            ])
            //->add('tags')
            ->add('Valider', SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_article';
    }


}
