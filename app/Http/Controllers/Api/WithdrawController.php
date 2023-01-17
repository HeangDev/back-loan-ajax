<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Withdraw;
use App\Models\Deposit;

class WithdrawController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $deposit = Deposit::where('id_customer', $request->id)
        ->update([
            'deposit_amount' => '0',
            'description' => 'การถอนกำลังตรวจสอบ'
        ]);

        $withdraw = Withdraw::create([
            'id_customer' => $request->id,
            'withdraw_amount' => $request->credit,
            'status' => 'คุณถอนสำเร็จแล้ว',
            'withdraw_date' => $currentDate,
            'withd_code' => $request->withdrawCode
        ]);
        return response()->json([
            $withdraw,
            $deposit
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $withdraw = Withdraw::where('id_customer', $id)->latest()->first();
        return response()->json($withdraw);
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
        //
    }
}
