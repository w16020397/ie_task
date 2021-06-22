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
        ["Period", "Basic Payment", "Bonus Payment"]
    ];
    private string $basicSalaryFormat = "last day of this month 9am +%d months";
    private string $bonusSalaryFormat = "first day of this month 9am +%d months";

    public function generate(int $months = 12): array
    {
        for ($count = 0; $count < $months; $count++)
        {
            $basicSalary = $this->calculateBasicSalaryDate($count);
            $bonusSalary = $this->calculateBonusDate($count);
            $period = date('M-y', strtotime($basicSalary));

            array_push($this->dates, [
                $period,
                $basicSalary,
                $bonusSalary
            ]);
        }

        return $this->dates;
    }

    /**
     * Calculates the date when a bonus payment is supposed to take place.
     * 
     * @param int $monthCount The amount of months to add to the current month.
     * 
     * @return string The formatted date.
     */
    private function calculateBonusDate(int $monthCount): string
    {
        $timestampFormat = sprintf($this->bonusSalaryFormat,  $monthCount);
        $dateTime = new \DateTime();

        /* strtotime() does not seem to be able to add days or weeks when getting the first day of a month.
        as a workaround, you can do the two additions independently.
        */
        $dateTime->setTimestamp(
            strtotime('+9 days', strtotime($timestampFormat))
        );
        $dayNumber = $dateTime->format('N');

        # Any day higher than 5 is a weekend.
        if($dayNumber >= 6)
        {
            # If the day is a saturday, we want to add 2 days worth of seconds, otherwise just 1.
            $secondsToAdd = ($dayNumber == 6) ? 172800 : 86400;
            $dateTime->setTimestamp($dateTime->getTimestamp() + $secondsToAdd);
        }

        return $dateTime->format('Y-m-d');
    }

    /**
     * Calculates when a basic salary payment should take place.
     * 
     * @param int $monthCount The amount of months to add to the current month.
     * 
     * @return string The formatted date.
     */
    private function calculateBasicSalaryDate(int $monthCount): string
    {
        $timestampFormat = sprintf($this->basicSalaryFormat, $monthCount);

        $dateTime = new \DateTime();
        $dateTime->setTimestamp(strtotime($timestampFormat));
        $dayNumber = $dateTime->format('N');

        if($dayNumber >= 6)
        {
            # If the day is a saturday, we subtract a day, otherwise we subtract 2 days.
            $secondsToSubtract = ($dayNumber == 6) ? 86400 : 172800;
            $dateTime->setTimestamp($dateTime->getTimestamp() - $secondsToSubtract);
        }

        return $dateTime->format('Y-m-d');
    }
}