@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เปลี่ยนรหัสผ่าน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">เปลี่ยนรหัสผ่าน</li>
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
                            <h4 class="card-title float-left">เปลี่ยนรหัสผ่าน</h4>
                            <a href="{{ route('admin.customer.index') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-chevron-left"></i> รายชื่อลูกค้า</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.customer.cheagepassword') }}" autocomplete="off">
                                @csrf
                                <div class="row">
                                    {{-- <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label>รหัสผ่านเก่า <span style="color: red;">*</span></label>
                                            <input type="password" class="form-control @error('oldpass') is-invalid @enderror" name="oldpass">
                                            @error('oldpass')
                                                <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label>รหัสผ่านใหม่ <span style="color: red;">*</span></label>
                                            <input type="password" class="form-control @error('newpass') is-invalid @enderror" name="newpass">
                                            @error('newpass')
                                                <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label>ยืนยันรหัสผ่าน <span style="color: red;">*</span></label>
                                            <input type="password" class="form-control @error('confirmpass') is-invalid @enderror" name="confirmpass">
                                            @error('confirmpass')
                                                <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-success" name="btnsave" id="btnsave"><i class="far fa-save"></i> อัปเดต</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection