<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Deposit;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $deposit = Deposit::create([
            'id_customer' => $request->id_customer,
            'withdraw_code' => $request->withdrawCode,
            'deposit_amount' => $request->amount,
            'description' => $request->description,
            'deposit_date' => $currentDate,
            'status' => '1'
        ]);

        return $deposit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(request()->ajax()) {
            return datatables()->of(
                Deposit::where('customers.id', '=', $id)
                ->join('customers', 'customers.id', '=', 'deposits.id_customer')
                ->select('customers.*', 'deposits.*')
                ->get()
            )
            ->addIndexColumn()
            ->addColumn('action', function($deposit) {
            return  '<a onclick="editForm('. $deposit->id .')" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a>' 
                    . ' <a onclick="deleteData('. $deposit->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a>';
            })->make(true);
        }

        $deposit = Deposit::where('id_customer', $id)->first();
        return view('deposit.deposit', [
            'deposit' => $deposit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $deposit = Deposit::find($id);
        return $deposit;
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
        $deposit = Deposit::where('id', $id)
        ->update([
            'withdraw_code' => $request->withdrawCode,
            'deposit_amount' => $request->amount,
            'description' => $request->description,
            'deposit_date' => $currentDate,
            'status' => '1'
        ]);

        return $deposit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deposit = Deposit::find($id);
        $deposit->delete();
        return response()->json($deposit);
    }
}
