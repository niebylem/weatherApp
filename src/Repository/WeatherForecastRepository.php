<?php

namespace App\Repository;

use App\Entity\Place;
use App\Entity\WeatherForecast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WeatherForecast|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherForecast|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherForecast[]    findAll()
 * @method WeatherForecast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherForecastRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WeatherForecast::class);
    }

    /**
     * function returns newest weather for Place given in parameter
     * @param Place $place
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTodayWeatherForPlace(Place $place) : Collection
    {
        $weather = $this->createQueryBuilder('wh')
            ->andWhere('wh.place = :place')
            ->setParameter('place', $place->getId())
            ->andWhere('wh.date = :date')
            ->setParameter('date', date('Y-m-d'))
            ->getQuery()
            ->getOneOrNullResult();

        return $weather;
    }

    /**
     * function returns three newest forecasts for Place given in parameter in ascending order
     * @param Place $place
     * @return array
     * @throws \Exception
     */
    public function getThreeDayWeatherForecastForPlace(Place $place) : Collection
    {
        $dateTo = new \DateTime();
        $dateTo->add(new \DateInterval('P3D'));
        $weatherForecast = $this->createQueryBuilder('wh')
            ->andWhere('wh.place = :place')
            ->setParameter('place', $place->getId())
            ->andWhere('wh.date BETWEEN :from AND :to')
            ->setParameter('from', date('Y-m-d H:i:s'))
            ->setParameter('to', $dateTo->format('Y-m-d H:i:s'))
            ->orderBy('wh.date', 'ASC')
            ->getQuery()
            ->getResult();

        $weatherForecast = new ArrayCollection($weatherForecast);
        return $weatherForecast;
    }

    public function findNewestForPlace(Place $place) : ?WeatherForecast
    {
        $weather = $this->findBy(
            ['place' => $place->getId()],
            ['date' => 'DESC'],
            1
        );

        return $weather[0] ?? null;
    }

    public function saveNewWeatherForecast(WeatherForecast $weatherForecast)
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($weatherForecast);
            $entityManager->flush();
        } catch (ORMException $ex) {
            // @TODO some error handling
            return false;
        }
        return true;
    }
}
