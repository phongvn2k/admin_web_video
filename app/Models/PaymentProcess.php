<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProcess extends Model
{
    use HasFactory;

    protected $table = 'payment_process';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'order'
    ];
}
