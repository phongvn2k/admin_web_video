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
}
