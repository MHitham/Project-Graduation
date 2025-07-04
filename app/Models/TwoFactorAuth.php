<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFactorAuth extends Model
{
    use HasFactory;
    protected $table = 'two_factor_auth';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'code',
        'expired_at',
    ];

}
