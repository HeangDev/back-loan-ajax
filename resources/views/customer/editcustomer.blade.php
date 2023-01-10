@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">แก้ไขลูกค้า</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">แก้ไขลูกค้า</li>
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
                            <h4 class="card-title float-left">แก้ไขลูกค้า</h4>
                            <a href="{{ route('admin.customer.index') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-chevron-left"></i> รายชื่อลูกค้า</a>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.customer.createbyid') }}" autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" value="{{ $customer->id }}" name="id">
                                <fieldset>
                                    <legend>กรอกข้อมูลจริงและถูกต้องการตรวจสอบจะผ่านไป</legend>
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>อาชีพปัจจุบัน <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('currentWork') is-invalid @enderror" name="currentWork" value="{{$customer->current_occupation}}">
                                                @error('currentWork')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>รายได้ต่อเดือน <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('income') is-invalid @enderror" name="income" value="{{$customer->monthly_income}}">
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
                                                <input type="text" class="form-control @error('contactNumber') is-invalid @enderror" name="contactNumber" value="{{$customer->contact_number}}">
                                                @error('contactNumber')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>ที่อยู่ปัจจุบัน <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('currentAddress') is-invalid @enderror" name="currentAddress" value="{{$customer->current_address}}">
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
                                                <input type="text" class="form-control @error('otherContact') is-invalid @enderror" name="otherContact" value="{{$customer->emergency_contact_number}}">
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
                                                    <option value="{{ $customer->id }}" {{ $customer->id ==  $customer->id_coustomer ? 'selected' : '' }}>{{ \App\Models\Bank::bank_name($customer->bank_name) }}</option>
                                                    @foreach (\App\Models\Bank::bank_name() as $id => $name)
                                                    
                                                    @if($id == 15) 
                                                      @continue
                                                    @endif
                                                        <option value="{{$id}}" {{ (old('bank_type') == $id) ? 'selected' : ''}}>{{ $name }}</option>
                                                        
                                                    @endforeach
                                                    
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>หมายเลขบัญชี <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('bankAccount') is-invalid @enderror" name="bankAccount" value="{{$customer->bank_acc}}">
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
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$customer->name}}">
                                                @error('name')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label>เลขประจำตัว <span style="color: red;">*</span></label>
                                                <input type="text" class="form-control @error('idNumber') is-invalid @enderror" name="idNumber" value="{{$customer->id_number}}">
                                                @error('idNumber')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label>ใส่รูปบัตรประชาชนข้างหน้า <span style="color: red;">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="frontImage">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('frontImage')
                                                        <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                    @enderror
                                                    <div class="card">
                                                        <div class="img-frontImage"><img src="{{ asset('storage/customer/') . '/' . $customer->front }}" class="img-fluid rounded mx-auto d-block " id="upload-front"/></div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label>ใส่รูปบัตรประชาชนข้างหลัง <span style="color: red;">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="backImage">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                                @error('backImage')
                                                    <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                @enderror
                                                <div class="card">
                                                    <div class="img-backImage"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="form-group">
                                                <label>ใส่รูปบัตรประชาชนคู่กับใบหน้า <span style="color: red;">*</span></label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="fullImage">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                    @error('fullImage')
                                                        <span style="color: #df4759; font-size: 80%; margin-top: .25rem;">{{ $message }}</span>
                                                    @enderror
                                                    <div class="card">
                                                        <div class="img-fullImage"></div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                
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
    
    @section('script')
        <script type="text/javascript">
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

            //Reset input file
            $('input[type="file"][name="frontImage"]').val('');
            $('input[type="file"][name="backImage"]').val('');
            $('input[type="file"][name="fullImage"]').val('');

            //Image preview frontImage
            $('input[type="file"][name="frontImage"]').on('change', function(){
            var img_path = $(this)[0].value;
            var img_holder = $('.img-frontImage');
            var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
            if(extension == 'jpeg' || extension == 'jpg' || extension == 'png'){
                if(typeof(FileReader) != 'undefined'){
                    img_holder.empty();
                    var reader = new FileReader();
                    reader.onload = function(e){
                        
                        $('<img/>',{'src':e.target.result, 'width': '250', 'height': '250', 'class':'img-fluid rounded mx-auto d-block mt-1 mb-2'}).appendTo(img_holder);
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

        //Image front show
        $(function() {
            $('input[type="file"][name="frontImage"]').on('change', function(e) {
                $('#upload-front').hide(); 
            });
        });

         //Image preview backImage
         $('input[type="file"][name="backImage"]').on('change', function(){
            var img_path = $(this)[0].value;
            var img_holder = $('.img-backImage');
            var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
            if(extension == 'jpeg' || extension == 'jpg' || extension == 'png'){
                if(typeof(FileReader) != 'undefined'){
                    img_holder.empty();
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>',{'src':e.target.result, 'width': '250', 'height': '250', 'class':'img-fluid rounded mx-auto d-block mt-1 mb-2'}).appendTo(img_holder);
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

         //Image preview fullImage
         $('input[type="file"][name="fullImage"]').on('change', function(){
            var img_path = $(this)[0].value;
            var img_holder = $('.img-fullImage');
            var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();
            if(extension == 'jpeg' || extension == 'jpg' || extension == 'png'){
                if(typeof(FileReader) != 'undefined'){
                    img_holder.empty();
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>',{'src':e.target.result, 'width': '250', 'height': '250', 'class':'img-fluid rounded mx-auto d-block mt-1 mb-2'}).appendTo(img_holder);
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
    
@endsection