<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWebsite extends Model
{
    protected $table = 'user_website';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'website_id'
    ];
}
