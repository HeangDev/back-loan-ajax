@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add Customer</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title float-left">Add Customer</h4>
                            <a href="{{ route('admin.customer.index') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> Customer List</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.user.store') }}" autocomplete="off" enctype="multipart/form-data" id="userdata">
                                @csrf
                                <fieldset>
                                    <legend></legend>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>หมายเลขโทรศัพท์ <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('tel') is-invalid @enderror" name="tel">
                                                @error('tel')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>ตั้งรหัสผ่าน <span style="color: red;">*</span></label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                                                @error('password')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>กรอกข้อมูลจริงและถูกต้องการตรวจสอบจะผ่านไป</legend>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>อาชีพปัจจุบัน <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('currentWork') is-invalid @enderror" name="currentWork">
                                                @error('currentWork')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>รายได้ต่อเดือน <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('income') is-invalid @enderror" name="income">
                                                @error('income')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>เบอร์ติดต่อ <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('contactNumber') is-invalid @enderror" name="contactNumber">
                                                @error('contactNumber')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>ที่อยู่ปัจจุบัน <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('currentAddress') is-invalid @enderror" name="currentAddress">
                                                @error('currentAddress')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>เบอร์ติดต่อฉุกเฉิน <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('otherContact') is-invalid @enderror" name="otherContact">
                                                @error('otherContact')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>คำเตือน:บัตรธนาคารที่คุณกรอกต้องเป็นตัวคุณเอง</legend>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>บัญชีธนาคาร</label>
                                                <select class="form-control" name="bankName">
                                                    <option value="ธนาคารไทยพาณิชย์ （SCB）">ธนาคารไทยพาณิชย์ （SCB）</option>
                                                    <option value="ธนาคาร กสิกรไทย （KBANK  )">ธนาคาร กสิกรไทย （KBANK  )</option>
                                                    <option value="ธนาคาร กรุงศรีอยุธยา （ BAY )">ธนาคาร กรุงศรีอยุธยา （ BAY )</option>
                                                    <option value="ธนาคาร กรุงไทย （KTB  )">ธนาคาร กรุงไทย （KTB  )</option>
                                                    <option value=" ธนาคาร กรุงเทพ（ BBL )"> ธนาคาร กรุงเทพ（ BBL )</option>
                                                    <option value="ธนาคาร ทหารไทย （TTB )">ธนาคาร ทหารไทย （TTB )</option>
                                                    <option value="ธนาคาร ธนชาติ（ TBANK )">ธนาคาร ธนชาติ（ TBANK )</option>
                                                    <option value="ธนาคาร ออมสิน( GSB)">ธนาคาร ออมสิน( GSB)</option>
                                                    <option value="ธนาคาร ยูโอบี (UOB )">ธนาคาร ยูโอบี (UOB )</option>
                                                    <option value="ธนาคาร ไอซีบีซี( ICBC)">ธนาคาร ไอซีบีซี( ICBC)</option>
                                                    <option value=" ธนาคาร การเกษตรและสหกรณ์ ธ ก ส（BAAC）"> ธนาคาร การเกษตรและสหกรณ์ ธ ก ส（BAAC）</option>                
                                                    <option value="ธนาคาร ซีไอเอ็มบี ไทย(CIMB)">ธนาคาร ซีไอเอ็มบี ไทย(CIMB)</option>
                                                    <option value="ธนาคาร อื่นๆ">ธนาคาร อื่นๆ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>หมายเลขบัญชี <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('bankAccount') is-invalid @enderror" name="bankAccount">
                                                @error('bankAccount')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>กรอกข้อมูลจริงและถูกต้องรีวิวจะผ่าน</legend>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>ชื่อ <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                                                @error('name')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>เลขประจำตัว <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('idNumber') is-invalid @enderror" name="idNumber">
                                                @error('idNumber')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>ใส่รูปบัตรประชาชนข้างหน้า <span style="color: red;">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="frontImage">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('frontImage')
                                                        <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>ใส่รูปบัตรประชาชนข้างหลัง <span style="color: red;">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="backImage">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                                @error('backImage')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>ใส่รูปบัตรประชาชนคู่กับใบหน้า <span style="color: red;">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="fullImage">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('fullImage')
                                                        <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                
                                <div class="row">
                                    <button type="submit" class="btn btn-success" name="btnsave" id="btnsave"><i class="far fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection