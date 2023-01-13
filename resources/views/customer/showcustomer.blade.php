@extends('layout.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if (Auth::user()->avatar == 'default.png')
                                    <img src="{{ asset('assets/img/default.svg') }}" class="img-circle elevation-2"
                                        alt="User Image" width="100px">
                                @else
                                    <img src="{{ asset('storage/customer/') . '/' . Auth::customer()->avatar }}"
                                        class="img-circle elevation-2" alt="User Image" width="100px">
                                @endif
                            </div>
                            <h3 class="profile-username text-center">{{ $customer->name }}</h3>
                            <p class="text-muted text-center">{{ $customer->tel }}</p>
                        </div>

                    </div>


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">รายละเอียดข้อมูล</h3>
                        </div>

                        <div class="card-body">
                            <strong><i class="fas fa-map-marker-alt mr-1"></i>ธนาคาร</strong>
                            <p class="text-muted">
                                เลขบัญชี {{$customer->bank_acc}}<br/>
                                ธนาคาร {{ \App\Models\Bank::bank_name($customer->bank_name) }}
                            </p>
                            
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i>ที่อยู่ปัจจุบัน</strong>
                            <p class="text-muted">
                                {{$customer->current_address}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-book mr-1"></i> เงินเดือน</strong>
                            <p class="text-muted">{{$customer->monthly_income}}</p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt mr-1"></i> อาชีพปัจจุบัน</strong>
                            <p class="text-muted">
                                {{$customer->current_occupation}}
                            </p>
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> เบอร์ติดต่อฉุกเฉิน *</strong>
                            <p class="text-muted">{{$customer->emergency_contact_number}}</p>
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="text-center">ใส่รูปบัตรประชาชนข้างหน้า *</div>
                                </div>
                                <div class="card-body">
                                    <img src="{{ asset('storage/customer/') . '/' . $customer->front }}" class="img-fluid"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="text-center">ใส่รูปบัตรประชาชนข้างหลัง *</div>
                                </div>
                                <div class="card-body">
                                    <img src="{{ asset('storage/customer/') . '/' . $customer->back }}" class="img-fluid"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <div class="text-center">ใส่รูปบัตรประชาชนคู่กับใบหน้า *</div>
                                </div>
                                <div class="card-body">
                                    <img src="{{ asset('storage/customer/') . '/' . $customer->full }}" class="img-fluid"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        
                                            <div class="card-header">
                                                <div class="text-center">ลายเซ็น *</div>
                                                
                                            </div>
                                            <div class="card-body">
                                                @if($customer->sign == null)
                                                    ยังไม่ได้เช็นชื่อ
                                                @else
                                                <img src="{{ asset('storage/customer/') . '/' . $customer->sign }}" class="img-fluid"/>
                                                @endif
                                            </div>
                                        
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
