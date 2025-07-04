<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginTokens extends Model
{
    use HasFactory;
    protected $table = 'login_tokens';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
    ];
}
