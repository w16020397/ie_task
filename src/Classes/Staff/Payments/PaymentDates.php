<?php

/**
 * A class to handle getting the payment dates.
 * 
 * @author Michael Sumner <michaelchrissumner@gmail.com>
 * @version 0.1 
 */
namespace App\Classes\Staff\Payments;

use App\Classes\Staff\Payments\Types\{BasicPayment, BonusPayment};

class PaymentDates
{
    private BasicPayment $basicPayment;
    private BonusPayment $bonusPayment;
    public array $dates = [];

    public function __construct()
    {
        $this->basicPayment = new BasicPayment;
        $this->bonusPayment = new BonusPayment;
    }

    /**
     * Gets an array of basic and bonus payment dates.
     * 
     * @param int $months The amount of months you want to get payments for.
     * 
     * @return array The payment dates.
     */
    public function getDates(int $months = 12): array
    {
        for ($count = 0; $count < $months; $count++)
        {
            array_push($this->dates, [
                $this->basicPayment->getDate($count),
                $this->bonusPayment->getDate($count),
                $this->basicPayment->getCurrentPeriod()
            ]);
        }

        return $this->dates;
    }
}