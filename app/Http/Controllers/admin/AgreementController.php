<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agreement;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Agreement::select('*'))
            ->addIndexColumn()
            ->addColumn('action', function($agreement_id) {
                return  '<a href="' .route('admin.agreement.edit', $agreement_id->id). '" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a>' .
                        ' <a onclick="deleteData('. $agreement_id->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a>';
            })->make(true);
        }

        return view('agreement.agreement');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agreement.addagreement');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Agreement::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => '1'
        ]);

        return redirect()->route('admin.agreement.index');
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
        $agreement  = Agreement::where('id', $id)->first();
        return view('agreement.editagreement', [
            'agreement' => $agreement
        ]);
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
        $agreement = Agreement::find($id);
        $agreement->title = $request->title;
        $agreement->description = $request->description;
        $agreement->status = $request->status;
        $agreement->save();

        return redirect()->route('admin.agreement.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agreement = Agreement::find($id);
        $agreement->delete();
    }
}
