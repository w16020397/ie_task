<?php

/**
 * A class to generate payment dates.
 * 
 * @author Michael Sumner <michaelchrissumner@gmail.com>
 * @version 0.1 
 */

namespace App\Classes\Staff;

class PaymentDates
{
    public array $dates = [
        "basicSalaryDates" => [],
        "bonusDates" => []
    ];
    private string $currentMonth;
    private string $basicSalaryFormat = "last day of this month 9am +%d months";
    private string $bonusSalaryFormat = "first day of this month 9am +%d months";

    public function generate(int $months = 12): array
    {
        for ($count = 0; $count < $months; $count++)
        {
            array_push($this->dates["basicSalaryDates"], $this->calculateBasicSalaryDate($count));
            array_push($this->dates["bonusDates"], $this->calculateBonusDate($count));
        }

        return $this->dates;
    }

    private function calculateBonusDate(int $monthCount): string
    {
        $timestampFormat = sprintf($this->bonusSalaryFormat,  $monthCount);
        $dateTime = new \DateTime();
        $dateTime->setTimestamp(
            strtotime('+9 days', strtotime($timestampFormat))
        );
        $dayNumber = $dateTime->format('N');

        if($dayNumber >= 6)
        {
            $secondsToSubtract = ($dayNumber == 6) ? 172800 : 86400;
            $dateTime->setTimestamp($dateTime->getTimestamp() + $secondsToSubtract);
        }

        return $dateTime->format('Y-M-d H:i:s');
    }

    private function calculateBasicSalaryDate(int $monthCount): string
    {
        $timestampFormat = sprintf($this->basicSalaryFormat, $monthCount);

        $dateTime = new \DateTime();
        $dateTime->setTimestamp(strtotime($timestampFormat));
        $dayNumber = $dateTime->format('N');

        if($dayNumber >= 6)
        {
            $secondsToSubtract = ($dayNumber == 6) ? 86400 : 172800;
            $dateTime->setTimestamp($dateTime->getTimestamp() - $secondsToSubtract);
        }

        return $dateTime->format('Y-M-d H:i:s');
    }
}