<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Customer;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'tel' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where('tel', $request->tel)->first();

        if (! $customer || ! Hash::check($request->password, $customer->password)) {
            throw ValidationException::withMessages([
                'tel' => ['หมายเลขโทรศัพท์หรือรหัสผ่านของคุณไม่ถูกต้อง.'],
            ]);
        } else {
            $token = $customer->createToken($request->tel . '_CustomerToken')->plainTextToken;

            return response()->json([
                'status' => 200,
                'id' => $customer->id,
                'token' => $token
            ], 200);
        }
    }

    public function changePassword(Request $request)
    {
        $customer = Customer::find($request->id_user);
        $customer->password = Hash::make($request->newPassword);
        $customer->plain_password = $request->newPassword;
        $customer->save();
        return response()->json([
            'status' => 200,
            $customer
        ], 200); 
    }

    public function getInfo($id)
    {
        $customer = Customer::where('id', $id)->first();
        return response()->json($customer);
    }
}
