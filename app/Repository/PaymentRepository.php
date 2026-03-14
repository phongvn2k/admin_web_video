<?php

namespace App\Repository;

use App\Models\Payment;

class PaymentRepository
{
    public function addPayment($data)
    {
        $data = Payment::create($data);

        return $data;
    }

    public function getPaymentById($id)
    {
        $data = Payment::where('id', $id)->first();
        return $data;
    }

    public function getPaymentByWebsite($webId)
    {
        $data = Payment::where('website_id', $webId)->get();
        return $data;
    }

    public function getAmountByWebsite($webId, $status)
    {
        $amount = Payment::where('website_id', $webId)
            ->whereIn('payment_process_id', $status)
            ->sum('amount');

        return $amount;
    }
}
