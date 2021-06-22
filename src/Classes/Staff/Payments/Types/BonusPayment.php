<?php

namespace App\Classes\Staff\Payments\Types;

use App\Classes\Staff\Payments\Types\BasePayment;
use App\Classes\Staff\Payments\Interfaces\PaymentDate;

class BonusPayment extends BasePayment implements PaymentDate
{
    /**
     * Calculates the date when a bonus payment is supposed to take place.
     * 
     * @param int $monthIncrement The amount of months to add to the current month.
     * 
     * @return string The formatted date.
     */
    public function getDate(int $monthIncrement = 0): string
    {
        // Set the format to the first day of the current month, plus any additional months.
        $this->format = $this->format($this->getBasicSalaryFormat(), $monthIncrement);
        $this->date = $this->date();
        $this->setTimestamp();
        $this->dayNumber = $this->day($this->date);

        if($this->dayNumber >= 6)
        {
            // If the day is saturday, we add 2 days, otherwise 1 day.
            $seconds = ($this->dayNumber == 6) ? 172800 : 86400;
            $this->date = $this->addSeconds($this->date, $seconds);
        }

        $this->dateString = $this->date->format('Y-m-d');

        return $this->dateString;
    }

    /**
     * Sets the timestamp of the current date to 9 days after what it is set to.
     */
    public function setTimestamp(): void
    {
        $this->date->setTimestamp(
            strtotime('+9 days', strtotime($this->format))
        );
    }
}