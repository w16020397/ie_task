<?php

namespace App\Classes\Staff\Payments\Types;

use App\Classes\Staff\Payments\Tools\Formatter;

class BasePayment extends Formatter
{
    protected \DateTime $date;
    protected string $format;
    protected int $dayNumber;
    protected string $dateString;

    /**
     * Returns a formatted version of the currently set date string.
     * 
     * @param string $format The format to pass to the date() function.
     * 
     * @return string The formatted date.
     */
    public function getCurrentPeriod(string $format = 'M-y'): string
    {
        if(!$this->dateString)
        {
            throw new Exception("The get date method must be called before retrieving a period.");
        }

        return date($format, strtotime($this->dateString));
    }
}