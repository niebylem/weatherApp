<?php

namespace App\Repository;

use App\Entity\WeatherCondition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WeatherCondition|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherCondition|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherCondition[]    findAll()
 * @method WeatherCondition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherConditionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WeatherCondition::class);
    }

    public function saveNewConditions(ArrayCollection $weatherConditions): ArrayCollection
    {
        $existingWeatherConditions = new ArrayCollection();
        foreach ($weatherConditions as $index => $weatherCondition) {
            if ($weatherCondition instanceof WeatherCondition) {
                $existingWeatherCondition = $this->findOneById($weatherCondition->getId());
                if ($existingWeatherCondition === null) {
                    $this->getEntityManager()->persist($weatherCondition);
                    $this->getEntityManager()->flush();
                    $existingWeatherConditions->add($weatherCondition);
                } else {
                    $existingWeatherConditions->add($existingWeatherCondition);
                }
            }
        }

        return $existingWeatherConditions;
    }

    public function findOneById(int $id)
    {
        return $this->createQueryBuilder('wc')
            ->andWhere('wc.id = :id')
            ->setParameter('id', $id)
            ->getQuery()->getOneOrNullResult();
    }

    // /**
    //  * @return WeatherCondition[] Returns an array of WeatherCondition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WeatherCondition
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
