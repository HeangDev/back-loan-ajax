<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Duration;
use App\Models\DocumentId;
use DB;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(
                Loan::join('customers', 'customers.id', '=', 'loans.id_customer')
                ->join('document_ids', 'document_ids.id_customer', '=', 'loans.id_customer')
                ->join('durations', 'durations.id', '=', 'loans.id_duration')
                ->select('loans.*', 'customers.tel AS customer_tel', 'document_ids.name AS customer_name', 'durations.month AS duration_month', 'durations.percent AS duration_percent')
                ->orderBy('id', 'DESC')
            )
            ->addIndexColumn()
            ->addColumn('action', function($loan) {
                return  '<a onclick="editData('. $loan->id .')" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a> ' .
                        '<a onclick="deleteData('. $loan->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a>';
            })->make(true);
        }
       
        $durations = Duration::all();
        $loan = Loan::join('customers', 'customers.id', '=', 'loans.id_customer')
        ->join('document_ids', 'document_ids.id_customer', '=', 'loans.id_customer')
        ->join('durations', 'durations.id', '=', 'loans.id_duration')
        ->select('loans.*', 'customers.tel AS customer_tel', 'document_ids.name AS customer_name','durations.id AS duration_id', 'durations.month AS duration_month', 'durations.percent AS duration_percent')
        ->first();
        return view('loan.loan',[
            'loan' => $loan,
            'durations' => $durations,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = Loan::find($id);
        return $loan;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loan = Loan::find($id);
        $loan->delete();
    }



    // Notification

    public function reload_Notifications() {
        $loans = Loan::whereDate('created_at', Carbon::today())
        ->where('confirm','0')
        ->where('amount', '>', '0')
        ->orderBy('id', 'DESC')->latest()->get();
        return view('notification/reload-notification', [
            'loans' => $loans,
        ]);
    }

    public function reload_Badge_Notifications() {
        $loans = Loan::whereDate('created_at', Carbon::today())
        ->where('confirm','0')
        ->where('amount', '>', '0')
        ->orderBy('id', 'DESC')->latest()->get();
        return view('notification/reload-badge-icon-notification', [
            'loans' => $loans,
        ]);
    }

    public function readed_Notifications(Request $request, $id)
    {
        $loan = Loan::find($id)
        ->update([
            'confirm' => '1'
        ]);

        return $loan;
    }
    
}
