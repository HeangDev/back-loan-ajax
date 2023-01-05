<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'withdraw_code',
        'deposit_amount',
        'description',
        'deposit_date'
    ];
}
