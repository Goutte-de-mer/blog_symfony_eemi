<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findAllDesc(int $page, int $limit): Paginator
    {

        return new Paginator(
            $this
                ->createQueryBuilder('a')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit)
                ->orderBy('a.createdAt', 'DESC') // Trier par date décroissante
                ->getQuery()
                ->setHint(Paginator::HINT_ENABLE_DISTINCT, false)
        );
    }

    public function findLatest(int $limit = 3): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC') // Trier par date décroissante
            ->setMaxResults($limit) // Limiter à 3 articles
            ->getQuery()
            ->getResult();
    }


    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
