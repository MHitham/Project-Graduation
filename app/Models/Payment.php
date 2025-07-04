<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        "cart_id",
        "order_id",
        "payment_date",
        "price",
        "payment_method_id"
    ];
}
