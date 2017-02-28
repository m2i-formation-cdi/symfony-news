<?php


namespace AppBundle\Form\DataTransformer;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EntityToIntDataTransformer implements DataTransformerInterface
{
    private $em;
    private $entityClass;
    //private $entityType;
    private $entityRepository;

    /**
     * @param EntityManager $em
     * @param $entityClass
     * @param $entityRepository
     */
    public function __construct(EntityManager $em, $entityClass, $entityRepository)
    {
        $this->em = $em;
        $this->entityClass = $entityClass;
        $this->entityRepository = $entityRepository;
    }

    /**
     * @param mixed $entity
     *
     * @return integer
     */
    public function transform($entity)
    {
        // Modified from comments to use instanceof so that base classes or interfaces can be specified
        if (null === $entity ||!$entity instanceof $this->entityClass) {
            // updated due to https://github.com/LRotherfield/Form/commit/140742b486352a5c9ac97590ae09f6d8b7f5be7f
            return '';
        }

        return $entity->getId();
    }

    /**
     * @param mixed $id
     *
     * @throws TransformationFailedException
     *
     * @return mixed|object
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            //updated due to https://github.com/LRotherfield/Form/commit/2be11d1c239edf57de9f6e418a067ea9f1f8c2ed
            return null;
        }

        $entity = $this->em->getRepository($this->entityRepository)->findOneBy(array("id" => $id));

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'A %s with id "%s" does not exist!',
                $this->entityClass,
                $id
            ));
        }

        return $entity;
    }

    /*
     function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }*/

    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    public function setEntityRepository($entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }


}