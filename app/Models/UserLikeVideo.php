<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikeVideo extends Model
{
    use HasFactory;

    protected $table = 'user_like_video';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'video_id'
    ];
}
