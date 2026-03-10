<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userbank extends Model
{
    use HasFactory;

    protected $table = 'user_bank';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'bank_id',
        'website_id',
        'name',
        'number',
    ];
}
