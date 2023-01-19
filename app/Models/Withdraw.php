<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'id_deposit',
        'withdraw_amount',
        'after_amount',
        'withdraw_code',
        'withdraw_date',
        'status'
    ];
}
