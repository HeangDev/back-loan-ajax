<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Withdraw;

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
                ->join('deposits', 'deposits.id_customer', '=', 'withdraws.id_customer')
                ->select('withdraws.*', 'customers.tel', 'document_ids.name', 'deposits.withdraw_code' )
                ->orderBy('id', 'DESC')
            )
            ->addIndexColumn()
            ->addColumn('action', function($withdraw) {
                return  '<a href="' .route('admin.withdraw.edit', $withdraw->id). '" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a>' .
                        ' <a onclick="deleteData('. $withdraw->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a>';
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
        if(request()->ajax()) {
            return datatables()->of(
                Withdraw::where('customers.id', '=', $id)
                ->join('users', 'users.id', '=', 'withdraws.id_user')
                ->select('users.*', 'withdraws.*')
                ->get()
            )
            ->addIndexColumn()
            ->addColumn('action', function($withdraw) {
                return '<a onclick="editForm('. $withdraw->id .')" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a>' . ' <a onclick="deleteData('. $withdraw->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a>';
            })->make(true);
        }
        
        $withdraw = Withdraw::where('id_customer', $id)->first();
        return view('withdraw.withdraw', [
            'withdraw' => $withdraw
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
            'withdraw_date' => $currentDate
        ]);
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
    }
}
