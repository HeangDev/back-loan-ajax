<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Bank;
use App\Models\DocumentId;
use App\Models\Signature;
use App\Models\Deposit;

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
                ->select('customers.*',  'document_ids.name', 'signatures.status AS sign_status')
                ->orderBy('id', 'DESC')
            )
            ->addIndexColumn()
            ->addColumn('action', function($customer) {
                if ($customer->status === 'complete') {
                    return
                    '<a href="' .route('admin.customer.edit', $customer->id). '" class="btn btn-primary btn-xs text-white"><i class="fa fa-edit"></i> แก้ไข</a> ' .
                    '<a onclick="changepassword('. $customer->id .')" class="btn btn-warning btn-xs text-white"><i class="fa fa-lock"></i> เปลี่ยนรหัสผ่าน</a> ' .
                    '<a href="' .route('admin.customer.show', $customer->id). '" class="btn btn-success btn-xs text-white"><i class="fa fa-eye"></i> แสดง</a> ' .
                    '<a href="' .route('admin.deposit.show', $customer->id). '" class="btn btn-info btn-xs text-white"><i class="fa fa-dollar-sign"></i> เติมเงิน</a> ' .
                    '<a onclick="deleteData('. $customer->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i></a>'. 
                    '<a onclick="changeStatus('. $customer->id .')" class="btn btn-success btn-xs text-white  ml-1"><i class="fa fa-check"></i></a>';                                 
                } else {
                    return 
                    '<a href="' .route('admin.customer.viewcreatebyid', $customer->id). '" class="btn btn-primary btn-xs text-white"><i class="fa fa-check"></i> สร้าง</a> ' .
                    '<a onclick="changepassword('. $customer->id .')" class="btn btn-warning btn-xs text-white"><i class="fa fa-lock"></i> เปลี่ยนรหัสผ่าน</a> ' .
                    '<a href="' .route('admin.customer.show', $customer->id). '" class="btn btn-success btn-xs text-white"><i class="fa fa-eye"></i> แสดง</a> ' .
                    '<a href="' .route('admin.deposit.show', $customer->id). '" class="btn btn-info btn-xs text-white"><i class="fa fa-dollar-sign"></i> เติมเงิน</a> ' .
                    '<a onclick="deleteData('. $customer->id .')" class="btn btn-danger btn-xs text-white"><i class="fa fa-trash"></i></a>'. 
                    '<a  class="btn btn-danger btn-xs text-white ml-1" ><i class="fa fa-check" disabled></i></a>';
                }
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
        $this->validate($request, [
            'tel' => 'required|unique:customers',
            'password' => 'required|min:6',
            'currentWork' => 'required',
            'income' => 'required',
            'contactNumber' => 'required',
            'currentAddress' => 'required',
            'otherContact' => 'required',
            'bankAccount' => 'required',
            'name' => 'required',
            'idNumber' => 'required',
            'frontImage' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            'backImage' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            'fullImage' => 'required|image|mimes:jpeg,jpg,png|max:1024',
        ],[
            'tel.required' => 'ต้องระบุหมายเลขโทรศัพท์.',
            'password.required' => 'ต้องการรหัสผ่าน.',
            'password.min' => 'รหัสผ่านควรมีอย่างน้อย 6 ตัวอักษร',
            'currentWork.required' => 'อาชีพปัจจุบันต้องไม่ว่างเปล่า.',
            'income.required' => 'รายได้ต่อเดือนไม่ว่างเปล่า.',
            'contactNumber.required' => 'เบอร์ติดต่อไม่ว่างเปล่า.',
            'currentAddress.required' => 'ที่อยู่ปัจจุบันไม่ว่างเปล่า.',
            'otherContact.required' => 'ที่อยู่ปัจจุบันไม่ว่างเปล่า.',
            'bankAccount.required' => 'จำเป็นต้องมีบัญชีธนาคาร.',
            'name.required' => 'ชื่อจริงของคุณที่จำเป็น.',
            'idNumber.required' => 'จำเป็นต้องมีหมายเลขประจำตัวที่แท้จริงของคุณ.',
            'frontImage.required' => 'ใส่รูปบัตรประจำตัวด้านหน้าต้องไม่เว้นว่าง.',
            'backImage.required' => 'ใส่รูปบัตรประจำตัวด้านหน้าต้องไม่เว้นว่าง.',
            'fullImage.required' => 'ใส่รูปบัตรประจำตัวด้านหน้าต้องไม่เว้นว่าง.',
        ]);

        $image1 = $request->file('frontImage');
        $image2 = $request->file('backImage');
        $image3 = $request->file('fullImage');

        if (isset($image1) && isset($image2) && isset($image3)) {
            $currentDate = Carbon::now()->toDateString();

            $imageName1 = $currentDate . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $imageName2 = $currentDate . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $imageName3 = $currentDate . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('customer'))
            {
                Storage::disk('public')->makeDirectory('customer');
            }

            $postImage1 = Image::make($image1)->stream();
            $postImage2 = Image::make($image2)->stream();
            $postImage3 = Image::make($image3)->stream();

            Storage::disk('public')->put('customer/' . $imageName1, $postImage1);
            Storage::disk('public')->put('customer/' . $imageName2, $postImage2);
            Storage::disk('public')->put('customer/' . $imageName3, $postImage3);
        }

        $customer = Customer::create([
            'tel' => $request->tel,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'current_occupation' => $request->currentWork,
            'monthly_income' => $request->income,
            'contact_number' => $request->contactNumber,
            'current_address' => $request->currentAddress,
            'emergency_contact_number' => $request->otherContact,
            'status' => 'complete',
        ]);

        $u_id = $customer->id;

        $deposit = Deposit::create([
            'id_customer' => $u_id,
            'description' => 'กำลังดำเนินการ',
        ]);

        $signature = Signature::create([
            'id_customer' => $u_id,
            'status' => '0',
        ]);

        $document = DocumentId::create([
            'id_customer' => $u_id,
            'name' => $request->name,
            'id_number' => $request->idNumber,
            'front' => $imageName1,
            'back' => $imageName2,
            'full' => $imageName3,
        ]);

        $bank = Bank::create([
            'id_customer' => $u_id,
            'bank_name' => $request->bankName,
            'bank_acc' => $request->bankAccount,
        ]);

        return redirect()->route('admin.customer.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::join('banks', 'banks.id_customer', '=', 'customers.id')
            ->join('document_ids', 'document_ids.id_customer', '=', 'customers.id')
            ->join('signatures', 'signatures.id_customer', '=', 'customers.id')
            ->select('customers.*', 'banks.*', 'document_ids.*', 'signatures.*')
            ->where('customers.id', '=', $id)
            ->first();
        return view('customer.showcustomer', [
            'customer' => $customer
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
        
        $customer = Customer::join('banks', 'banks.id_customer', '=', 'customers.id')
            ->join('document_ids', 'document_ids.id_customer', '=', 'customers.id')
            ->select('customers.*', 'customers.id AS customer_id', 'banks.*', 'document_ids.*')
            ->where('customers.id', '=', $id)
            ->first();
        return view('customer.editcustomer', [
            'customer' => $customer,
            
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
      //
    }

    public function updateCustomer(Request $request, $id)
    {

        $document = DocumentId::where('id_customer', $request->id)->first();
        
        $image1 = $request->file('frontImage');
        $image2 = $request->file('backImage');
        $image3 = $request->file('fullImage');

            if (isset($image1) && isset($image2) && isset($image3)) {
                $currentDate = Carbon::now()->toDateString();

                $imageName1 = $currentDate . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
                $imageName2 = $currentDate . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
                $imageName3 = $currentDate . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();

                if(!Storage::disk('public')->exists('customer'))
                {
                    Storage::disk('public')->makeDirectory('customer');
                }

                $postImage1 = Image::make($image1)->stream();
                $postImage2 = Image::make($image2)->stream();
                $postImage3 = Image::make($image3)->stream();

                Storage::disk('public')->delete('customer/' . $document->front );
                Storage::disk('public')->delete('customer/' . $document->back);
                Storage::disk('public')->delete('customer/' . $document->full);

                Storage::disk('public')->put('customer/' . $imageName1, $postImage1);
                Storage::disk('public')->put('customer/' . $imageName2, $postImage2);
                Storage::disk('public')->put('customer/' . $imageName3, $postImage3);

                $document = DocumentId::where('id_customer', $request->id)
            ->update([
                'front' => $imageName1,
                'back' => $imageName2,
                'full' => $imageName3,
            ]);  
            }

            $document = DocumentId::where('id_customer', $request->id)
            ->update([
                'name' => $request->name,
                'id_number' => $request->idNumber,

            ]);

        $customer = Customer::where('id', $request->id)
        ->update([
            'current_occupation' => $request->currentWork,
            'monthly_income' => $request->income,
            'contact_number' => $request->contactNumber,
            'current_address' => $request->currentAddress,
            'emergency_contact_number' => $request->otherContact,
            'status' => 'complete',
            'id_admin' => auth()->user()->id
        ]);

        $bank = Bank::where('id_customer', $request->id)
        ->update([
            'bank_name' => $request->bankName,
            'bank_acc' => $request->bankAccount,
        ]);

        return redirect()->route('admin.customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::join('banks', 'banks.id_customer', '=', 'customers.id')
        ->join('document_ids', 'document_ids.id_customer', '=', 'customers.id')
        ->join('signatures', 'signatures.id_customer', '=', 'customers.id')
        ->select('customers.*', 'banks.*', 'document_ids.*', 'signatures.status AS sign_status')
        ->where('customers.id', '=', $id)
        ->first();

        Storage::disk('public')->delete('customer/' . $customer->front);
        Storage::disk('public')->delete('customer/' . $customer->back);
        Storage::disk('public')->delete('customer/' . $customer->full);

        Storage::delete('public/customer' . '/' . $customer->front);
        Storage::delete('public/customer' . '/' . $customer->back);
        Storage::delete('public/customer' . '/' . $customer->full);

        $document = DocumentId::where('id_customer', $id);
        $document->delete();
        $deposit = Deposit::where('id_customer', $id);
        $deposit->delete();

        $signature = Signature::where('id_customer', $id);
        $signature->delete();
        $customer = Customer::find($id);
        $customer->delete();
    }

    public function updatePassword(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->password = Hash::make($request->newpass);
        $customer->plain_password = $request->newpass;
        $customer->save();
        return $customer;
    }

    public function viewCreateById($id)
    {
        $customer = Customer::find($id);
        return view('customer.createbyid', [
            'customer' => $customer
        ]);
    }

    public function createById(Request $request)
    {
        $this->validate($request, [
            'currentWork' => 'required',
            'income' => 'required',
            'contactNumber' => 'required',
            'currentAddress' => 'required',
            'otherContact' => 'required',
            'bankAccount' => 'required',
            'name' => 'required',
            'idNumber' => 'required',
            'frontImage' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            'backImage' => 'required|image|mimes:jpeg,jpg,png|max:1024',
            'fullImage' => 'required|image|mimes:jpeg,jpg,png|max:1024',
        ],[
            'currentWork.required' => 'อาชีพปัจจุบันต้องไม่ว่างเปล่า.',
            'income.required' => 'รายได้ต่อเดือนไม่ว่างเปล่า.',
            'contactNumber.required' => 'เบอร์ติดต่อไม่ว่างเปล่า.',
            'currentAddress.required' => 'ที่อยู่ปัจจุบันไม่ว่างเปล่า.',
            'otherContact.required' => 'ที่อยู่ปัจจุบันไม่ว่างเปล่า.',
            'bankAccount.required' => 'จำเป็นต้องมีบัญชีธนาคาร.',
            'name.required' => 'ชื่อจริงของคุณที่จำเป็น.',
            'idNumber.required' => 'จำเป็นต้องมีหมายเลขประจำตัวที่แท้จริงของคุณ.',
            'frontImage.required' => 'ใส่รูปบัตรประจำตัวด้านหน้าต้องไม่เว้นว่าง.',
            'backImage.required' => 'ใส่รูปบัตรประจำตัวด้านหน้าต้องไม่เว้นว่าง.',
            'fullImage.required' => 'ใส่รูปบัตรประจำตัวด้านหน้าต้องไม่เว้นว่าง.',
        ]);

        $image1 = $request->file('frontImage');
        $image2 = $request->file('backImage');
        $image3 = $request->file('fullImage');

        if (isset($image1) && isset($image2) && isset($image3)) {
            $currentDate = Carbon::now()->toDateString();

            $imageName1 = $currentDate . '-' . uniqid() . '.' . $image1->getClientOriginalExtension();
            $imageName2 = $currentDate . '-' . uniqid() . '.' . $image2->getClientOriginalExtension();
            $imageName3 = $currentDate . '-' . uniqid() . '.' . $image3->getClientOriginalExtension();

            if(!Storage::disk('public')->exists('customer'))
            {
                Storage::disk('public')->makeDirectory('customer');
            }

            $postImage1 = Image::make($image1)->stream();
            $postImage2 = Image::make($image2)->stream();
            $postImage3 = Image::make($image3)->stream();

            Storage::disk('public')->put('customer/' . $imageName1, $postImage1);
            Storage::disk('public')->put('customer/' . $imageName2, $postImage2);
            Storage::disk('public')->put('customer/' . $imageName3, $postImage3);
        }

        $customer = Customer::where('id', $request->id)
        ->update([
            'current_occupation' => $request->currentWork,
            'monthly_income' => $request->income,
            'contact_number' => $request->contactNumber,
            'current_address' => $request->currentAddress,
            'emergency_contact_number' => $request->otherContact,
            'status' => 'complete',
        ]);

        $document = DocumentId::where('id_customer', $request->id)
        ->update([
            'name' => $request->name,
            'id_number' => $request->idNumber,
            'front' => $imageName1,
            'back' => $imageName2,
            'full' => $imageName3,
        ]);

        $bank = Bank::where('id_customer', $request->id)
        ->update([
            'bank_name' => $request->bankName,
            'bank_acc' => $request->bankAccount,
        ]);

        return redirect()->route('admin.customer.index');

    }

    public function getcustomerid($id)
    {
        $customer_id = Customer::find($id);
        return $customer_id;
    }

    public function changeStatus(Request $request, $id)
    {
        $customer = Customer::where('id', $id)->first();
        $customer->update([
            'status' => 'incomplete',
            'id_admin' =>  auth()->user()->id
        ]);
        return response()->json($customer);
    }
}
