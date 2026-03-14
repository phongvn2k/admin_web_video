<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentProcess extends Model
{
    use HasFactory;

    protected $table = 'payment_process';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'order'
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
}
