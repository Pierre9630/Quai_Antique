<?php

namespace App\Repository;

use App\Entity\OpeningHours;
use App\Entity\Reservation;
use DateTimeInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OpeningHours>
 *
 * @method OpeningHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpeningHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpeningHours[]    findAll()
 * @method OpeningHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpeningHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpeningHours::class);
    }

    public function save(OpeningHours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OpeningHours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Check if the restaurant is open at the given date and time.
     *
     * @param OpeningHours $openingHours The opening hours of the restaurant.
     * @param \DateTimeInterface $dateTime The date and time to check.
     *
     * @return bool True if the restaurant is open, false otherwise.
     */
    public static function isOpen(OpeningHours $openingHours, \DateTimeInterface $dateTime): bool
    {
        // Get the day of the week of the given date and time.
        $dayOfWeek = $dateTime->format('N');

        // Check if the day of the week matches the opening hours.
        if ($dayOfWeek != $openingHours->getDayOfWeek()) {
            return false;
        }

        // Get the opening and closing times of the restaurant.
        $openingTime = $openingHours->getOpeningTime();
        $closingTime = $openingHours->getClosingTime();

        // Check if the given time is within the opening hours.
        if ($dateTime < $openingTime || $dateTime > $closingTime) {
            return false;
        }

        // The restaurant is open.
        return true;
    }




//    /**
//     * @return OpeningHours[] Returns an array of OpeningHours objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OpeningHours
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
