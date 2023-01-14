<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $count_customer_loan = Customer::join('loans', 'loans.id_customer', '=', 'customers.id')
        ->select(DB::raw("count(loans.id_customer) AS count"))->groupBy('customers.id')->count();
        $count_customer_withdraw = Customer::join('withdraws', 'withdraws.id_customer', '=', 'customers.id')
        ->select(DB::raw("count(withdraws.id_customer) AS count"))->groupBy('customers.id')->count();
        $customer = Customer::count();
        $user = User::count();
        return view('dashboard', [
            'customer' => $customer,
            'user' => $user,
            'count_customer_loan' => $count_customer_loan,
            'count_customer_withdraw' => $count_customer_withdraw
        ]);
    }
}
