@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ข้อตกลง</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">แก้ไขข้อตกลง</li>
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
                            <h4 class="card-title float-left">แก้ไขข้อตกลง</h4>
                            <a href="{{ route('admin.agreement.index') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> รายการข้อตกลง</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.agreement.update', $agreement->id) }}" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">ชื่อ <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control" name="title" id="title" value="{{$agreement->title}}">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">สถานะ <span style="color: red;">*</span></label>
                                            <textarea class="form-control" name="description" id="description">{{$agreement->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="">สถานะ <span style="color: red;">*</span></label>
                                            <select class="form-control" name="status" id="status">
                                                @if ($agreement->status == '1')
                                                    <option value="1">ใช้งาน</option>
                                                    <option value="0">ปิดการใช้งาน</option>
                                                @else
                                                    <option value="0">ปิดการใช้งาน</option>
                                                    <option value="1">ใช้งาน</option>
                                                @endif
                                            </select>
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

@section('script')
    <script type="text/javascript">
        $('#description').summernote({
            height: 350,
            lang: 'th-TH',
            toolbar: [
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize', 'fontsizeunit']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['table', 'link']],
                ['view', ['fullscreen', 'undo', 'redo']],
            ],
            popover: {
                link: [
                    ['link', ['linkDialogShow', 'unlink']]
                ],
                table: [
                    ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                    ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                ],
                air: [
                    ['color', ['color']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'paragraph']],
                    ['table', ['table']],
                ]
            },
        });
    </script>
@endsection