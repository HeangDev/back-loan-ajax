<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Message::select('*'))
            ->addIndexColumn()
            ->addColumn('action', function($message_id) {
                return'<a onclick="editForm('. $message_id->id .')" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a>' 
                    . ' <a onclick="deleteData('. $message_id->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a>';
            })->make(true);
        }
        return view('message.message');
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
        $message = Message::create([
            'tel' => $request->tel,
            'amount' => $request->amount,
            'date' => $request->date,
            'status' => $request->status,
            'id_admin' => auth()->user()->id
        ]);
        return $message;
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
        $message = Message::find($id);
        return $message;
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
        $message = Message::find($id);
        $message->tel = $request->tel;
        $message->amount = $request->amount;
        $message->date = $request->date;
        $message->status = $request->status;
        $message->id_admin = auth()->user()->id;
        $message->save();

        return $message;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        $message->delete();
        return response()->json($message);
    }
}
