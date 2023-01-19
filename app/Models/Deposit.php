<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'deposit_amount',
        'withdraw_code',
        'description',
        'deposit_date',
        'status'
    ];
}
