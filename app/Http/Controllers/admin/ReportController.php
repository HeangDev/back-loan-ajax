<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdraw;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;

class ReportController extends Controller
{
    public function viewWithdrawReport(Request $request)
    {
        if(request()->ajax()) {
            if (!empty($request->startdate)) {
                $data = Withdraw::join('customers', 'customers.id', '=', 'withdraws.id_customer')
                    ->join('document_ids', 'document_ids.id_customer', '=', 'withdraws.id_customer')
                    ->whereBetween('withdraws.withdraw_date', array($request->startdate, $request->enddate))
                    ->select('document_ids.name AS customer_name', 'customers.contact_number', 'customers.emergency_contact_number', 'withdraws.after_amount', 'withdraws.withdraw_date')
                    ->get();
            } else {
                $data = Withdraw::join('customers', 'customers.id', '=', 'withdraws.id_customer')
                    ->join('document_ids', 'document_ids.id_customer', '=', 'withdraws.id_customer')
                    ->select('document_ids.name AS customer_name', 'customers.contact_number', 'customers.emergency_contact_number', 'withdraws.after_amount', 'withdraws.withdraw_date')
                    ->get();
            }

            return datatables()->of($data)->addIndexColumn()->make(true);
        }

        return view('report.withdraw');
    }

    public function viewLoanReport(Request $request)
    {
        return view('report.loan');
    }
}
