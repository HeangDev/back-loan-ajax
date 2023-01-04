<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
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
                Customer::join('document_ids', 'document_ids.id_customer', '=', 'customers.id')
            ->join('signatures', 'signatures.id_customer', '=', 'customers.id')
            ->join('deposits', 'deposits.id_customer', '=', 'customers.id')
            ->select('customers.*', 'document_ids.name', 'signatures.status AS sign_status', 'deposits.withdraw_code', 'deposits.deposit_amount', 'deposits.description AS deposits_status')
            )
            ->addIndexColumn()
            ->addColumn('action', function($customer) {
                return '
                <a href="' .route('admin.customer.edit', $customer->id). '" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a> ' .
                '<a onclick="deleteData('. $customer->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a> ' .
                '<a href="' .route('admin.customer.edit', $customer->id). '" class="btn btn-warning btn-xs text-white"><i class="fa fa-lock"></i> เปลี่ยนรหัสผ่าน</a> ' .
                '<a href="' .route('admin.customer.show', $customer->id). '" class="btn btn-success btn-xs text-white"><i class="fa fa-eye"></i> แสดง</a> ';
            })->make(true);
        }

        return view('customer.customer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer.createcustomer');
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
        //
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

    public function viewChangePassword()
    {

    }

    public function cheagePassword(Request $request, $id)
    {

    }
}
