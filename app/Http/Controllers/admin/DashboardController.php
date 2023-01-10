<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = Customer::count();
        $user = User::count();
        return view('dashboard', [
            'customer' => $customer,
            'user' => $user
        ]);
    }
}
