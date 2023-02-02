<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use App\Models\Loan;
use App\Models\Withdraw;
use App\Models\Duration;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $durations = Duration::all();
        $loan_chart = Loan::join('customers', 'customers.id', '=', 'loans.id_customer')
        ->join('document_ids', 'document_ids.id_customer', '=', 'loans.id_customer')
        ->join('durations', 'durations.id', '=', 'loans.id_duration')
        ->select('loans.*', 'customers.tel AS customer_tel', 'document_ids.name AS customer_name','durations.id AS duration_id', 'durations.month AS duration_month', 'durations.percent AS duration_percent')
        ->get();


        $loan = Loan::where('approved', 'yes')->distinct('id_customer')->count('id_customer');
        $withdraw = Withdraw::where('with_approved', 'yes')->distinct('id_customer')->count('id_customer');
        $customer = Customer::count();
        $user = User::count();
        return view('dashboard', [
            'customer' => $customer,
            'user' => $user,
            'loan' => $loan,
            'withdraw' => $withdraw
        ]);
    }
}
