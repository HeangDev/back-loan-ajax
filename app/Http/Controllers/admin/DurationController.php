<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Duration;

class DurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Duration::select('*'))
            ->addIndexColumn()
            ->addColumn('action', function($duration_id) {
                return'<a onclick="editForm('. $duration_id->id .')" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a>' 
                    . ' <a onclick="deleteData('. $duration_id->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a>';
            })->make(true);
        }
        return view('duration.duration');
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

        $duration = Duration::create([
            'month' => $request->month,
            'percent' => $request->percent,
            'status' => $request->status,
            'id_admin' => auth()->user()->id
        ]);
        return $duration;
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
        $duration = Duration::find($id);
        return $duration;
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
        $duration = Duration::find($id);
        $duration->month = $request->month;
        $duration->percent = $request->percent;
        $duration->status = $request->status;
        $duration->id_admin = auth()->user()->id;
        $duration->save();

        return $duration;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $duration = Duration::find($id);
        $duration->delete();
    }
}
