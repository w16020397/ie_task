<?php

namespace App\Classes\Staff\Payments\Interfaces;

interface PaymentDate
{
    public function getDate(int $monthIncrement): string;
    public function setTimestamp(): void;
}