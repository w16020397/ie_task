<?php

/**
 * An interface for each payment date.
 * 
 * @author Michael Sumner <michaelchrissumner@gmail.com>
 * @version 0.1 
 */
namespace App\Classes\Staff\Payments\Interfaces;

interface PaymentDate
{
    public function getDate(int $monthIncrement): string;
    public function setTimestamp(): void;
}