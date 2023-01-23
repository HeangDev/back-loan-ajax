<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentId extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'name',
        'id_number',
        'front',
        'back',
        'full'
    ];


    public function customer() {
        return $this->belongsTo(Customer::class,'id_customer','id');
    }

    public function loan() {
        return $this->belongsToMany(Loan::class,'id','id_customer');
    }
    public function withdraw() {
        return $this->belongsToMany(Withdraw::class,'id','id_customer');
    }
}
