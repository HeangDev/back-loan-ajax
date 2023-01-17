<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'id_duration',
        'amount',
        'interest',
        'total',
        'pay_month',
        'date',
        'status',
        'confirm'
    ];

    
    public function customer() {
        return $this->belongsTo(Customer::class,'id_customer','id');
    }

    public function document_id() {
        return $this->hasOne(DocumentId::class,'id','id_customer');
    }
}
