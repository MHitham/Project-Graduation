<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;

    public $table = 'reset_passwords';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
    ];
}
