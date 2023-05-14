<?php
namespace App\Service;

use App\Entity\OpeningHours;
use App\Entity\Reservation;
use Carbon\Carbon;
use DateInterval;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;


class ResSlots
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * Format the opening hours as a string.
     *
     * @param OpeningHours $openingHours The opening hours to format.
     *
     * @return string The formatted opening hours.
     */
    public static function format(OpeningHours $openingHours): string
    {
        // Define an array of weekday names.
        $daysOfWeek = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        // Get the day of the week of the opening hours.
        $dayOfWeek = $daysOfWeek[$openingHours->getDayOfWeek()];

        // Get the opening and closing times of the opening hours.
        $openingTime = $openingHours->getOpeningTime()->format('H:i');
        $closingTime = $openingHours->getClosingTime()->format('H:i');

        // Format the opening hours as a string.
        return sprintf('%s: %s - %s', $dayOfWeek, $openingTime, $closingTime);
    }
    /*
    /**
     * Get the available time slots for a given day, taking into account existing reservations.
     *
     * @param int $day The day of the week (0 = Sunday, 1 = Monday, etc.).
     * @param string $openTime The opening time of the restaurant for the given day (format: 'H:i').
     * @param string $closeTime The closing time of the restaurant for the given day (format: 'H:i').
     * @param array $existingReservations An array of existing reservations for the given day, each with a 'date_res' field (format: 'H:i').
     * @param int $slotDuration The duration of each time slot, in minutes.
     *
     * @return array An array of available time slots for the given day, in the format 'H:i'.
     */

    /**
     * @throws \Exception
     */
    public function getAvailableTimeSlots(EntityManager $em,Carbon $date, int $nb_cutelry, int $slotDuration = 15): array
    {
        $openingHoursRepository = $this->em->getRepository(OpeningHours::class);
        $reservationsRepository = $this->em->getRepository(Reservation::class);

        $dayOfWeek = intval($date->format('w'));
        //var_dump($dayOfWeek);
        $openingHours = $openingHoursRepository->findOneBy(['day' => $dayOfWeek]);

        if (!$openingHours) {
            return []; // Le restaurant est fermé ce jour-là
        }

        $start = clone $date;
        //dd($start);

        $start = Carbon::today()->setTimeFromTimeString($openingHours->getOpenTime()->format('H:i:s'));

        $end = clone $date;
        $end = Carbon::today()->setTimeFromTimeString($openingHours->getCloseTime()->format('H:i:s'));

        // Créer un tableau de toutes les plages horaires possibles pour ce jour
        $slots = [];
        $current = clone $start;
        while ($current <= $end) {
            $slots[] = clone $current;
            $current->add(new DateInterval('PT' . $slotDuration . 'M'));
        }
        //dd($slots);
        // Supprimer les plages horaires déjà réservées
        $datestring = $date->format('Y-m-d');
        /*
                $date2 = \DateTime::createFromFormat('Y-m-d',$datestring);
                $reservations = $reservationsRepository->findBy(['date_res' => $date2 ]);*/
        $reservations = $reservationsRepository->selectDate($em,$datestring);
        //var_dump($reservations);
        if (!empty($reservations)) {
            foreach ($reservations as $reservation) {
                $slotToRemove = $reservation->getDateRes()->format('H:i:s');
                $key = array_search(date('Y-m-d H:i:s', strtotime($slotToRemove)), $slots);
                if ($key !== false) {
                    unset($slots[$key]);
                }
            }
        }
            //dd($slots);


        // Vérifier si la capacité maximale est atteinte pour chaque créneau horaire
        $bookings = $reservationsRepository->findBy(['date_res' => $date]);
        //dd($bookings);
        $bookingCount = 0;
        foreach ($bookings as $booking) {
            $bookingCount += $booking->getNbCutelry();
        }
        //dd($bookingCount);
        $maxCapacity = $this->getMaxCapacity($openingHours, $nb_cutelry);
        //dd('test' .$maxCapacity);
        //dd($maxCapacity);
        $availableSlots = [];
        foreach ($slots as $slot) {
            //$bookingCount += $nb_cutelry;
            //dd($bookingCount);
            //$i = 0;
            if ($bookingCount <= $maxCapacity) {
                //$i+=1;
                //var_dump($bookingCount);
                $availableSlots[] = $slot->format('H:i:s');
                //var_dump($availableSlots);
            } else {
                break; // Capacité maximale atteinte
            }
            //dd($slots);
        }
        //dd($availableSlots);
        return $availableSlots;
    }

    private function getMaxCapacity(OpeningHours $openingHours, int $nb_cutlery): int
    {
        $max_capacity = 55;
        $open_time = Carbon::parse($openingHours->getOpenTime());
        $close_time = Carbon::parse($openingHours->getCloseTime());
        $time_diff = $close_time->diffInMinutes($open_time);
        $time_slots = ceil($time_diff / 15);
        //dd($time_slots);
        $max_capacity_per_slot = floor($max_capacity / $time_slots);
        //dd($max_capacity_per_slot);
        return $max_capacity_per_slot;
        //return min($max_capacity_per_slot, $nb_cutlery);
    }
}