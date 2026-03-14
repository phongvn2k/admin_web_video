<?php

namespace App\Repository;

use App\Models\PaymentProcess;

class PaymentProcessRepository
{
    public function getOne()
    {
        $order = PaymentProcess::orderBy('order', 'asc')->first();
        return $order;
    }

    public function getAll($webId)
    {
        $order = PaymentProcess::where('website_id', $webId)->orderBy('order', 'asc')->get();
        return $order;
    }
}
