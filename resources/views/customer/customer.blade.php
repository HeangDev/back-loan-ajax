@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ลูกค้า</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">รายชื่อลูกค้า</li>
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
                            <h4 class="card-title float-left">รายชื่อลูกค้า</h4>
                            <a href="{{ route('admin.customer.create') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> เพิ่มลูกค้า</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="customer">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>เบอร์โทร</th>
                                        <th>เครดิต</th>
                                        <th>ข้อมูลอื่น ๆ</th>
                                        <th>ลายเซ็น</th>
                                        <th>สถานะการกู้</th>
                                        <th>รหัสถอน</th>
                                        <th>แก้ไขข้อมูล</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

	<div id="modal-form-changepass" class="modal fade">
		<div class="modal-dialog" role="document">
			<form method="POST" autocomplete="off">
				{{ csrf_field() }} {{ method_field('POST') }}
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="my-modal-title"></h5>
						<button class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="customer_id" name="customer_id">
						<div class="form-group">
							<label>รหัสผ่านใหม่ <span style="color: red;">*</span></label>
							<input type="password" class="form-control form-control-sm" name="newpass" id="newpass" required >
						</div> 
						<div class="form-group">
							<label>ยืนยันรหัสผ่าน <span style="color: red;">*</span></label>
							<input type="password" class="form-control form-control-sm" name="confirmpass" >
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-success btn-sm btn-save">ยืนยัน</button>
					</div>
			</form>	
				</div>
			
		</div>
	</div>

@endsection

@section('script')
    <script type="text/javascript">
        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var table = $('#customer').DataTable({
			responsive: true,
			autoWidth: false,
			processing: true,
			serverSide: true,
			"language": {
                "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
                "zeroRecords": "ไม่พบอะไร - ขอโทษ",
                "info": "กำลังแสดงหน้า _PAGE_ ของ _PAGES_",
                "infoEmpty": "ไม่มีระเบียนที่มีอยู่",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "ค้นหา:",
                "paginate": {
                    "previous": "หน้าก่อนหน้า",
                    "next": "หน้าต่อไป"
                }
            },
			ajax: {
				url: "{{ route('admin.customer.index') }}",
				type: 'GET',
			},
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{
					data: 'name',
					name: 'document_ids.name',
					render: function(data, type, full, meta) {
						if (data == '' || data == null) {
							return "ไม่สมบูรณ์";
						} else {
							return data;
						}
					},
				},
				{data: 'tel', name: 'tel'},
				{data: 'deposit_amount', name: 'deposits.deposit_amount'},
				{
					data: 'status',
					name: 'status',
					render: function(data, type, full, meta) {
						if (data == 'complete') {
							return "<span class='badge badge-pill badge-primary'>กรอกข้อมูลแล้ว</span>";
						} else {
							return "<span class='badge badge-pill badge-danger'>ไม่สมบูรณ์</span>";
						}
					},
				},
				{
					data: 'sign_status',
					name: 'signatures.status',
					render: function(data, type, full, meta) {
						if (data == '1') {
							return "<span class='badge badge-pill badge-primary'>เซ็นชื่อเรียบร้อยแล้วค่ะ</span>";
						} else {
							return "<span class='badge badge-pill badge-danger'>ยังไม่ได้เซ็นชื่อค่ะ</span>";
						}
					},
				},
				{data: 'deposits_status', name: 'deposits.description'},
				{
					data: 'withdraw_code',
					name: 'deposits.withdraw_code',
					render: function(data, type, full, meta) {
						if (data == '') {
							return "<span class='badge badge-pill badge-primary'>ยังไม่มีรหัสถอนเงินค่ะ</span>";
						} else {
							return "<span class='badge badge-pill badge-danger'>" + data + "</span>";
						}
					},
				},
				{data: 'action', name: 'action', orderable: false},
			],
			order: [[0, 'desc']]
		});

		$(function() {
            $('#modal-form-changepass form').on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                var id = $('#customer_id').val();
                $.ajax({
                    url: "{{ url('customer/updatepassword') . '/' }}" + id,
                    type: "POST",
                    data: $('#modal-form-changepass form').serialize(),
                    success: function(data) {
                        $('#modal-form-changepass').modal('hide');
                        table.ajax.reload();
                        swal.fire({
                            title: 'ความสำเร็จ!',
                            text: "ใส่ข้อมูลแล้ว!",
                            icon: "success",
                            timer: '1500'
                        })
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Oops...',
                            text: "Something went wrong!",
                            type: "error",
                            timer: '1500'
                        })
                    }
                });
                return false;
                }
            });
        });
		
		function changepassword(id) {
			save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form-changepass form')[0].reset();
            $.ajax({
                url: "{{ url('customer/getcustomerid') }}" + '/' + id + "/change",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form-changepass').modal('show');
                    $('.modal-title').text('แก้ไขระยะเวลา');
                    $('#customer_id').val(data.id);
                },
                error: function() {
                    swal({
                        title: 'Oops...',
                        text: "Nothing Data",
                        type: "error",
                        timer: '1500'
                    })
                }
            });
            
        }

		function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
				title: 'คุณต้องการที่จะลบ หรือไหม ?',
				text: "ถ้าลบแล้ว คุณจะเปลี่ยนกลับไม่ได้ นะค่ะ!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
                cancelButtonText: 'ยกเลิกการลบ',
				confirmButtonText: 'ลบข้อมูล'
			}).then((result) => {
				if (result.value) {
					$.ajax({
                        url: "{{ url('customer') }}" + '/' + id,
                        type: "POST",
                        data: {'_method' : 'DELETE', '_token' : csrf_token},
                        success: function(data) {
                            var oTable = $('#customer').dataTable();
							oTable.fnDraw(false);
                            swal.fire({
                                title: 'ความสำเร็จ!',
                                text: "ข้อมูลถูกลบ!",
                                icon: "success",
                                timer: '1500'
                            })
                        },
                        error: function() {
                            swal.fire({
                                title: 'Oops...',
                                text: "Something went wrong!",
                                icon: "error",
                                timer: '1500'
                            })
                        }
                    })
				}
			})
        }
		

    </script>
@endsection