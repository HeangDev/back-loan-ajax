<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\DocumentId;
use App\Models\Signature;
use App\Models\Deposit;
use App\Models\Loan;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $customer = Customer::create([
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
        ]);

        $c_id = $customer->id;

        Deposit::create([
            'id_customer' => $c_id,
            'description' => 'กำลังดำเนินการ',
            'status' => '1',
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

        Loan::create([
            'id_customer' => $c_id,
        ]);

        return response()->json([
            'status' => 200,
            $customer
        ], 200);
    }
}
