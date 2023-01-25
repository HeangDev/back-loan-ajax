<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Withdraw;
use App\Models\Deposit;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
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
                Withdraw::join('customers', 'customers.id', '=', 'withdraws.id_customer')
                ->join('document_ids', 'document_ids.id_customer', '=', 'withdraws.id_customer')
                ->select('withdraws.*', 'customers.contact_number AS customer_tel', 'document_ids.name AS customer_name')
                ->orderBy('id', 'DESC')
            )
            ->addIndexColumn()
            ->addColumn('action', function($withdraw) {
                if ($withdraw->with_approved === 'yes') {
                    return  '<a onclick="editData('. $withdraw->id .')" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a> ' .
                        '<a onclick="deleteData('. $withdraw->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a> '.
                        '<a onclick="approved('. $withdraw->id .')" class="btn btn-success btn-xs text-white disabled"><i class="fa fa-check"></i> การถอนล้มเหลว</a>';
                } else {
                    return  '<a onclick="editData('. $withdraw->id .')" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a> ' .
                        '<a onclick="deleteData('. $withdraw->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a> '.
                        '<a onclick="approved('. $withdraw->id .')" class="btn btn-success btn-xs text-white"><i class="fa fa-check"></i> การถอนล้มเหลว</a>';
                }
            })->make(true);
        }

        return view('withdraw.withdraw');
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
        $currentDate = Carbon::now()->toDateString();
        $withdraw = Withdraw::create([
            'id_customer' => $request->id_customer,
            'withdraw_amount' => $request->amount,
            'status' => $request->status,
            'withdraw_date' => $currentDate
        ]);

        return $withdraw;
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
        $withdraw = Withdraw::find($id);
        return $withdraw;
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
        
        $currentDate = Carbon::now()->toDateString();
        $withdraw = Withdraw::where('id', $id)
        ->update([
            'withdraw_amount' => $request->amount,
            'status' => $request->status,
            'with_approved' => 'no',
            'withdraw_date' => $currentDate
        ]);

        Deposit::where('id_customer', $request->customer_id)
        ->update([
            'description' => $request->status
        ]);
        return response()->json($withdraw);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $withdraw = Withdraw::find($id);
        $withdraw->delete();
        return response()->json($withdraw);
    }

    public function approved(Request $request, $id)
    {
        $withdraw = Withdraw::where('id', $id)->first();
        $withdraw->update([
            'withdraw_amount' => '0',
            'status' => 'การถอนล้มเหลว',
            'with_approved' => 'yes'
        ]);
        return response()->json($withdraw);
    }
}
