@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รีพอร์ตการกู้เงิน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">รีพอร์ตการกู้เงิน</li>
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
                            <h4 class="card-title float-left">รีพอร์ตการกู้เงิน</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-inline">
                                <label class="my-1 mr-2">วันที่เริ่มต้น: </label>
                                <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="startdate" id="startdate">
                                <label class="my-1 mr-2">วันที่สิ้นสุด: </label>
                                <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="enddate" id="enddate">
                                <button type="button" class="btn btn-success btn-sm my-1" id="btnshow"><i class="fas fa-search"></i> แสดง</button>
                            </div>
                            <div class="mt-3">
                                <table class="table table-bordered w-100" id="report_withdraw">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อ</th>
                                            <th>เบอร์ติดต่อ</th>
                                            <th>เบอร์ติดต่อฉุกเฉิน</th>
                                            <th>จำนวน</th>
                                            <th>วันที่ถอน</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection