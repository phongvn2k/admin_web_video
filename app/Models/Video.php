<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'website_id',
        'user_id',
        'title',
        'file',
        'description',
        'hashtag',
        'count_like',
        'count_view',
        "slug",
        "is_viral"
    ];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }
}
