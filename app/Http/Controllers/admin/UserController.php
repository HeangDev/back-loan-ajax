<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(User::select('*'))
            ->addIndexColumn()
            ->addColumn('action', function($user_id) {
                return '<a onclick="editForm('. $user_id->id .')" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a>' . ' <a onclick="deleteData('. $user_id->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i> ลบออก</a>';
            })->make(true);
        }
        return view('user.user');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.adduser');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required|min:6',
            'avatar' => 'mimes:jpeg,jpg,png,gif,svg',

        ]);

        $image = $request->file('avatar');
        
        if(isset($image)) {
            $currentDate = Carbon::now()->toDateString();
            $imageName  = $currentDate.'-' . uniqid() . '.' . $image->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('user'))
            {
                Storage::disk('public')->makeDirectory('user');
            }

            $postImage = Image::make($image)->resize(180,180)->stream();
            Storage::disk('public')->put('user/'.$imageName, $postImage);
        } else{
            $imageName = "default.png";
        }

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->status = 'active';
        $user->password = Hash::make($request->password);
        $user->plain_password = $request->password;
        $user->avatar = $imageName;
        $user->id_admin = auth()->user()->id;
        $user->save();

        return redirect()->route('admin.user.index');
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
        $user  = User::where('id', $id)->first();
        return response()->json($user);
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
        $user = User::where('id', $id)
        ->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'status' => $request->status,
            'id_admin' => auth()->user()->id,
        ]);

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Storage::delete('public/user' . '/' . $user->avatar);
        $user->delete();

        return response()->json($user);
    }

    public function userUpdate(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::find($user_id);

        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:users,name,'.$user_id,
            'username' => 'required|unique:users,username,'.$user_id,
        ]);

        if (!$validator->passes()) {
            return response()->json(['code' => 0, 'error' => $validator->errors()->toArray()]);
        } else {
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'status' => $request->status,
                'id_admin' => auth()->user()->id,
            ]);
    
            return response()->json(['code' => 1, 'success' => 'Data is successfully updated']);
        }
    }
}
