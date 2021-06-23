<?php

/**
 * A class to handle generating a basic payment date.
 * 
 * @author Michael Sumner <michaelchrissumner@gmail.com>
 * @version 0.1 
 */
namespace App\Classes\Staff\Payments\Types;

use App\Classes\Staff\Payments\Types\BasePayment;
use App\Classes\Staff\Payments\Interfaces\PaymentDate;

class BasicPayment extends BasePayment implements PaymentDate
{
    /**
     * Calculates the date when a basic payment is supposed to take place.
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
            // If the day is saturday, we want to subtract 1 day, otherwise 2 days.
            $seconds = ($this->dayNumber == 6) ? 86400 : 172800;
            $this->date = $this->subtractSeconds($this->date, $seconds);
        }

        $this->dateString = $this->date->format('Y-m-d');

        return $this->dateString;
    }

    /**
     * Sets the current timestamp to basic salary format.
     */
    public function setTimestamp(): void
    {
        $this->date->setTimestamp(strtotime($this->format));
    }
}