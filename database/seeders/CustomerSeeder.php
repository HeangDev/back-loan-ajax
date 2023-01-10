<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\DocumentId;
use App\Models\Signature;
use App\Models\Deposit;
use App\Models\Withdraw;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = Customer::create([
            'tel' => '011263262',
            'password' => Hash::make('password'),
            'plain_password' => 'password',
        ]);

        $c_id = $customer->id;

        Deposit::create([
            'id_customer' => $c_id,
            'description' => 'กำหลังดำเนินการ',
        ]);

        Signature::create([
            'id_customer' => $c_id,
            'status' => '0',
        ]);

        Bank::create([
            'id_customer' => $c_id,
        ]);

        DocumentId::create([
            'id_customer' => $c_id,
        ]);
    }
}
