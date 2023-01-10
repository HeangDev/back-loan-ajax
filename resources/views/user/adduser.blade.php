@extends('layout.app')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ผู้ใช้</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">เพิ่มผู้ใช้</li>
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
            				<h4 class="card-title float-left">เพิ่มผู้ใช้</h4>
            				<a href="{{ route('admin.user.index') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-list"></i> รายชื่อผู้ใช้</a>
            			</div>
            			<div class="card-body">
            				<form method="POST" action="{{ route('admin.user.store') }}" autocomplete="off" enctype="multipart/form-data" id="userdata">
                            @csrf
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label>ชื่อ <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name">
                                            @error('name')
                                                <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label>ชื่อผู้ใช้ <span style="color: red;">*</span></label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username">
                                            @error('username')
                                                <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label>รหัสผ่าน <span style="color: red;">*</span></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                            @error('password')
                                                <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label>อีเมล</label>
                                            <input type="email" class="form-control" name="email" id="email">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label>อิมเมจ</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('profile_photo_path') is-invalid @enderror" name="avatar" id="customFile">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                            @error('profile_photo_path')
                                                <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                            @enderror
                                            <div class="img-holder"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" class="btn btn-success" name="btnsave" id="btnsave"><i class="far fa-save"></i> บันทึก</button>
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
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        //Reset input file
        $('input[type="file"][name="avatar"]').val('');

        //Image preview
        $('input[type="file"][name="avatar"]').on('change', function(){
            var img_path = $(this)[0].value;
            var img_holder = $('.img-holder');
            var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
            if(extension == 'jpeg' || extension == 'jpg' || extension == 'png'){
                if(typeof(FileReader) != 'undefined'){
                    img_holder.empty();
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>',{'src':e.target.result, 'width': '100', 'class':'img-thumbnail mt-1 mb-2'}).appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                }else{
                    $(img_holder).html('This browser does not support FileReader');
                }
            }else{
                $(img_holder).empty();
            }
        });
    </script>

@endsection