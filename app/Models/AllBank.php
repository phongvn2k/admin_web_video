<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AllBank extends Model
{
    use HasFactory;

    protected $table = 'all_bank';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'code',
        'status',
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
}
