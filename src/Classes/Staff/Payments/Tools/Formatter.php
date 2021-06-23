<?php

/**
 * A class that provides methods that help in formatting a payment date.
 * 
 * @author Michael Sumner <michaelchrissumner@gmail.com>
 * @version 0.1 
 */
namespace App\Classes\Staff\Payments\Tools;

class Formatter
{
    private string $basicSalaryFormat = "last day of this month 9am +%d months";
    private string $bonusSalaryFormat = "first day of this month 9am +%d months";
    private DateTime $datetime;

    /**
     * Formats a string given a format and the data to be inserted.
     * 
     * @param string $formatPattern The string format.
     * @param mixed $data The data.
     * 
     * @return string The formatted string.
     */
    public function format(string $formatPattern, mixed $data): string
    {
        return sprintf($formatPattern, $data);
    }

    /**
     * Creates a new instance of DateTime()
     * 
     * @return DateTime A datetime instance.
     */
    public function date(): \DateTime
    {
        return new \DateTime();
    }

    /**
     * Gets the day number for a supplied datetime.
     * 
     * @param DateTime $datetime The datetime instance.
     * 
     * @return int The day number.
     */
    public function day(\DateTime $datetime): int
    {
        return $datetime->format('N');
    }

    /**
     * Add seconds to a given DateTime instance.
     * 
     * @param DateTime $datetime The date time instance.
     * @param int $seconds The amount of seconds you want to add.
     * 
     * @return DateTime The datetime object.
     */
    public function addSeconds(\DateTime $datetime, int $seconds): \DateTime
    {
        $datetime->setTimestamp($datetime->getTimestamp() + $seconds);

        return $datetime;
    }

    /**
     * Subtract seconds from a given datetime.
     * 
     * @param DateTime $datetime The date time instance.
     * @param int $seconds The amount of seconds you want to subtract.
     * 
     * @return DateTime The datetime object.
     */
    public function subtractSeconds(\DateTime $datetime, int $seconds): \DateTime
    {
        $datetime->setTimestamp($datetime->getTimestamp() - $seconds);

        return $datetime;
    }

    /**
     * Gets the bonus salary sprintf format.
     * 
     * @return string The sprintf format for a bonus salary date.
     */
    public function getBonusSalaryFormat(): string
    {
        return $this->bonusSalaryFormat;
    }

    /**
     * Gets the basic salary sprintf format.
     * 
     * @return string The sprintf format for a basic salary date.
     */
    public function getBasicSalaryFormat(): string
    {
        return $this->basicSalaryFormat;
    }
}