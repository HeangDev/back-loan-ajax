<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'withdraw_amount',
        'withd_code',
        'withdraw_date',
        'status'
    ];
}
