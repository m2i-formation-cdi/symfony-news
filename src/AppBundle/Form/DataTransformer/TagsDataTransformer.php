<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class TagsDataTransformer implements DataTransformerInterface
{

    private static $tagDelimiter = ',';

    private $entityManager;

    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->entityManager = $em;
        $this->repository = $em->getRepository('AppBundle:Tag');
    }

    public function transform($tagCollection)
    {
        $tagsArray = array_map(function($tagEntity){
            return $tagEntity->getTagName();
        },
            $tagCollection->toArray()
        );

        return implode(static::$tagDelimiter.' ', $tagsArray);
    }

    public function reverseTransform($value)
    {
        $tagsCollection = new ArrayCollection();

        // Transformation de la liste des tags en tableau
        $tagsArray = explode(static::$tagDelimiter, $value);
        // Nettoyage des tags
        $tagsArray = array_map(function($tag){
            return trim($tag);
        }, $tagsArray);
        // unicité des tags
        $tagsArray = array_unique($tagsArray);

        foreach($tagsArray as $tagName){
            if(! empty($tagName)){
                // Recherche d'un tag existant
                $tagEntity = $this->repository->findOneByTagName($tagName);

                // Si non trouvé, instanciation d'un nouveau tag
                if(! $tagEntity){
                    $tagEntity = new Tag();
                    $tagEntity->setTagName($tagName);
                }

                // Ajout du tag à la collection
                $tagsCollection->add($tagEntity);
            }
        }

        return $tagsCollection;
    }
}