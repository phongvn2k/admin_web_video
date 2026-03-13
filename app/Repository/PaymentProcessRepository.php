<?php

namespace App\Repository;

use App\Models\PaymentProcess;

class PaymentProcessRepository
{
    public function getOne()
    {
        $order = PaymentProcess::orderBy('order', 'desc')->first();
        return $order;
    }

    public function getAll()
    {
        $order = PaymentProcess::orderBy('order', 'desc')->get();
        return $order;
    }
}
