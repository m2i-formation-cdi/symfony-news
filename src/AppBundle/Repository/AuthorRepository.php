<?php
namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AuthorRepository extends EntityRepository
{
    public function getAuthorList(){
        $qb = $this->createQueryBuilder('w')
            ->select("CONCAT_WS(' ', w.firstName, w.name) as fullName,
                     COUNT(a.id) as numberOfArticles, w.id")
            ->leftJoin('w.articles', 'a')
            ->groupBy('w.id');

        return $qb->getQuery()->getArrayResult();
    }

}