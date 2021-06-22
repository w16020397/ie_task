<?php

namespace App\Classes\Staff\Payments\Tools;

class Formatter
{
    private string $basicSalaryFormat = "last day of this month 9am +%d months";
    private string $bonusSalaryFormat = "first day of this month 9am +%d months";
    private DateTime $datetime;

    public function format(string $formatPattern, mixed $data): string
    {
        return sprintf($formatPattern, $data);
    }

    public function date(): \DateTime
    {
        return new \DateTime();
    }

    public function day(\DateTime $datetime): int
    {
        return $datetime->format('N');
    }

    public function addSeconds(\DateTime $datetime, $seconds): \DateTime
    {
        $datetime->setTimestamp($datetime->getTimestamp() + $seconds);

        return $datetime;
    }

    public function subtractSeconds(\DateTime $datetime, $seconds): \DateTime
    {
        $datetime->setTimestamp($datetime->getTimestamp() - $seconds);

        return $datetime;
    }

    public function getBonusSalaryFormat(): string
    {
        return $this->bonusSalaryFormat;
    }

    public function getBasicSalaryFormat(): string
    {
        return $this->basicSalaryFormat;
    }
}