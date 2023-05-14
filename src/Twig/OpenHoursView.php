<?php

namespace App\Twig;

use App\Repository\OpeningHoursRepository;
use App\Twig\AppRuntime;
use Spatie\OpeningHours\OpeningHours;
use Twig\Extension\AbstractExtension;
//use Twig\TwigFilter;
use Twig\TwigFunction;

class OpenHoursView extends AbstractExtension
{
    public function __construct(OpeningHoursRepository $OpeningHoursRepository )
    {
         $this->OpeningHoursRepo = $OpeningHoursRepository;
    }

    public function getFunctions() : array
    {
        return [
            new TwigFunction('OpenHoursMethod',  [$this, 'getOpenHoursforWeek'], ['is_safe' => ['html']]),
            //new TwigFunction('OpenHoursMethod', [OpeningHours::class, 'OpenHoursMethod']),
        ];

    }
    public function getOpenHoursforWeek()
    {
        $sunday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 0, 'timeofday' => 'midday']);
        $sunday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 0, 'timeofday' => 'evening']);
        $monday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 1, 'timeofday' => 'midday']);
        $monday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 1, 'timeofday' => 'evening']);
        $tuesday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 2, 'timeofday' => 'midday']);
        $tuesday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 2, 'timeofday' => 'evening']);
        $wednesday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 3, 'timeofday' => 'midday']);
        $wednesday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 3, 'timeofday' => 'evening']);
        $thursday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 4, 'timeofday' => 'midday']);
        $thursday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 4, 'timeofday' => 'evening']);
        $friday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 5, 'timeofday' => 'midday']);
        $friday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 5, 'timeofday' => 'evening']);
        $saturday_morning = $this->OpeningHoursRepo->findOneBy(['day' => 6, 'timeofday' => 'midday']);
        $saturday_evening = $this->OpeningHoursRepo->findOneBy(['day' => 6, 'timeofday' => 'evening']);


        $openingHours = OpeningHours::create([
            'monday' => [$monday_morning->getOpenTime()->format('H:i') .'-' . $monday_morning->getCloseTime()->format('H:i'),
                $monday_evening->getOpenTime()->format('H:i') . '-' . $monday_evening->getCloseTime()->format('H:i')],
            'tuesday' => [$tuesday_morning->getOpenTime()->format('H:i') .'-' . $tuesday_morning->getCloseTime()->format('H:i'),
                $tuesday_evening->getOpenTime()->format('H:i') . '-' . $tuesday_evening->getCloseTime()->format('H:i')],
            'thursday' => [$thursday_morning->getOpenTime()->format('H:i') .'-' . $thursday_morning->getCloseTime()->format('H:i'),
                $thursday_evening->getOpenTime()->format('H:i') . '-' . $thursday_evening->getCloseTime()->format('H:i')],
            'friday' => [$friday_morning->getOpenTime()->format('H:i') .'-' . $friday_morning->getCloseTime()->format('H:i'),
                $friday_evening->getOpenTime()->format('H:i') . '-' . $friday_evening->getCloseTime()->format('H:i')],
            'saturday' => [$saturday_morning->getOpenTime()->format('H:i') .'-' . $saturday_morning->getCloseTime()->format('H:i'),
                $saturday_evening->getOpenTime()->format('H:i') . '-' . $saturday_evening->getCloseTime()->format('H:i')],
            'sunday' => [$sunday_morning->getOpenTime()->format('H:i') .'-' . $sunday_morning->getCloseTime()->format('H:i')],
        ]);

        return $openingHours->forWeek(); //$openingHours->asStructuredData('H:iP', '+01:00'),
    }
}