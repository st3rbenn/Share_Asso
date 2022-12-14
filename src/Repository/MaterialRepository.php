<?php

namespace App\Repository;

use App\Entity\Deal;
use App\Entity\Material;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Material>
 *
 * @method Material|null find($id, $lockMode = null, $lockVersion = null)
 * @method Material|null findOneBy(array $criteria, array $orderBy = null)
 * @method Material[]    findAll()
 * @method Material[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Material::class);
    }

    public function add(Material $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Material $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Material[] Returns an array of Category objects
     */
    public function search($searchTerm): array
    {
        if (empty($searchTerm)) {
            return $this->createQueryBuilder('m')
                ->where('m.id NOT IN (:deals)')
                ->setParameter('deals', $this->getEntityManager()->getRepository(Deal::class)->findAll())
                ->getQuery()
                ->getResult();
        }

        return $this->createQueryBuilder('m')
            ->orderBy('m.material_createdat', 'DESC')
            ->where('m.material_name LIKE :searchTerm')
            ->andWhere('m.id NOT IN (:deals)')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->setParameter('deals', $this->getEntityManager()->getRepository(Deal::class)->findAll())
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Material[] Returns an array of Material objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Material
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
