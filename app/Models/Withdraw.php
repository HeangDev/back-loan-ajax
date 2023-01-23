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
        'after_amount',
        'withdraw_date',
        'status',
        'confirm',
        'with_approved'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class,'id_customer','id');
    }

    public function document_id() {
        return $this->hasOne(DocumentId::class,'id','id_customer');
    }
}
