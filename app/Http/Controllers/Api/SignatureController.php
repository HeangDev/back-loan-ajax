<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use App\Models\Signature;

class SignatureController extends Controller
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
        $signature = Signature::where('id_customer', $id)->first();
        return response()->json($signature);
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
        if ($request->signature) {
            $currentDate = Carbon::now()->toDateString();
            $image = time().'.' . explode('/', explode(':', substr($request->signature, 0, strpos($request->signature, ';')))[1])[1];

            $imageName = $currentDate . '-' . uniqid() . '.' . $image;

            if(!Storage::disk('public')->exists('signature'))
            {
                Storage::disk('public')->makeDirectory('signature');
            }

            $postImage = Image::make($request->signature)->save(public_path('signature/') . $imageName);

            Storage::disk('public')->put('signature/' . $imageName, $postImage);
        }

        $signature = Signature::where('id_customer', $id)
        ->update([
            'sign' => $imageName,
            'status' => '1',
        ]);

        return response()->json([
            $signature
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
        //
    }
}
