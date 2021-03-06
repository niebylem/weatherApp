<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Place;
use App\Entity\Weather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Weather|null find($id, $lockMode = null, $lockVersion = null)
 * @method Weather|null findOneBy(array $criteria, array $orderBy = null)
 * @method Weather[]    findAll()
 * @method Weather[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Weather::class);
    }

    public function findNewestForPlace(Place $place) : ?Weather
    {
        $weather = $this->findBy(
            ['place' => $place->getId()],
            ['added' => 'DESC'],
            1
        );

        return $weather[0] ?? null;
    }

    public function saveNewWeather(Weather $weather) : bool
    {
        try {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($weather);
            $entityManager->flush();
        } catch (ORMException $ex) {
            // @TODO some error handling
            return false;
        }
        return true;
    }
}
