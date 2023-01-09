<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'tel',
        'password',
        'plain_password',
        'current_occupation',
        'monthly_income',
        'contact_number',
        'current_address',
        'emergency_contact_number',
        'credit',
        'status'
    ];
}
