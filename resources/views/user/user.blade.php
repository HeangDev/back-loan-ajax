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
                        <li class="breadcrumb-item active">รายชื่อผู้ใช้</li>
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
            				<h4 class="card-title float-left">รายชื่อผู้ใช้</h4>
            				<a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> เพิ่มผู้ใช้</a>
            			</div>
            			<div class="card-body">
            				<table class="table table-bordered table-striped" id="user">
            					<thead>
            						<tr>
										<th>#</th>
                                        <th>อิมเมจ</th>
            							<th>ชื่อ</th>
										<th>ชื่อผู้ใช้</th>
            							<th>อีเมล</th>
            							<th>สถานะ</th>
            							<th>ตัวเลือก</th>
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

	<div class="modal fade" id="modal-update-user">
		<div class="modal-dialog modal-lg">
		  	<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">อัปเดตผู้ใช้</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form method="POST" autocomplete="off" enctype="multipart/form-data" id="editUserData">
						{{ csrf_field() }} {{ method_field('POST') }}
						<input type="hidden" name="user_id" id="user_id">
						<div class="row">
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label>ชื่อ <span style="color: red;">*</span></label>
									<input type="text" class="form-control" name="name" id="edit_name">
									<span class="error-text name_error" style="color: #df4759; font-size: 80%; margin-top: .25rem;"></span>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label>ชื่อผู้ใช้ <span style="color: red;">*</span></label>
									<input type="text" class="form-control" name="username" id="edit_username">
									<span class="error-text username_error" style="color: #df4759; font-size: 80%; margin-top: .25rem;"></span>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label>อีเมล</label>
									<input type="email" class="form-control" name="email" id="edit_email">
									<span class="error-text email_error" style="color: #df4759; font-size: 80%; margin-top: .25rem;"></span>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="form-group">
									<label for="">สถานะ</label>
									<select class="form-control" name="status" id="edit_status">
										<option value="active">ใช้งาน</option>
										<option value="unactive">ปิดการใช้งาน</option>
									</select>
								</div>
							</div>
						</div>
					
				</div>
				<div class="modal-footer">
					<input type="hidden" name="action" id="action" />
					<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-window-close"></i> ปิด</button>
					<button type="submit" class="btn btn-success"><i class="far fa-save"></i> อัปเดต</button>
				</form>
				</div>
		  </div>
		</div>
	</div>

@endsection

@section('script')
    <script type="text/javascript">
        $('#nameError').addClass('d-none');
		$('#usernameError').addClass('d-none');
		$('#passwordError').addClass('d-none');
		$('#emailError').addClass('d-none');
		$('#imageError').addClass('d-none');

        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

        var table = $('#user').DataTable({
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
				url: "{{ route('admin.user.index') }}",
				type: 'GET',
			},
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{
					data: 'avatar',
					name: 'avatar',
					render: function(data, type, full, meta) {
						if (data == 'default.png') {
							return "<img src={{ asset('assets/img/default.svg') }} width='40' class='rounded-circle' />";
						} else {
							return "<img src={{ asset("storage/user/") }}/" + data + " width='40' class='rounded-circle' />";
						}
					},
					orderable: false
				},
				{data: 'name', name: 'name'},
				{data: 'username', name: 'username'},
				{
                    data: 'email',
                    name: 'email',
                    render: function(data, type, full, meta) {
						if (data == '' || data == null) {
							return "-";
						} else {
							return data;
						}
					},
                },
				{
					data: 'status',
					name: 'status',
					render: function(data, type, full, meta) {
						if (data == 'active') {
							return "<span class='badge badge-pill badge-primary'>ใช้งาน</span>";
						} else {
							return "<span class='badge badge-pill badge-danger'>ปิดการใช้งาน</span>";
						}
					},
				},
				{data: 'action', name: 'action', orderable: false},
			],
			order: [[0, 'desc']]
		});

        $('#addusermodal').click(function () {
			$('#modal-form-user form').trigger("reset");
			$('#modal-form-user').modal('show');
		});

        function editForm(id) {
			$('#modal-update-user form')[0].reset();
			$.ajax({
				url:"{{ url('user') }}" + '/' + id + "/edit",
				type: "GET",
				dataType:"json",
				success:function(data){
					$('#modal-update-user').modal('show');
					$('#user_id').val(data.id);
					$('#edit_name').val(data.name);
					$('#edit_username').val(data.username);
					$('#edit_email').val(data.email);
					$('#edit_status').val(data.status);
				}
			})
        }

		$('#editUserData').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ url('ajax-user-update')}}",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType:"json",
                success: function(data) {
					if (data.code == 0) {
                        $.each(data.error, function(prefix, val) {
        	            	$('#modal-update-user').find('span.'+prefix+'_error').text(val[0]);
                    	})
                	} else {
                        $('#modal-update-user').modal('hide');
						table.ajax.reload();
						swal.fire({
                            title: 'ความสำเร็จ!',
                            text: "ใส่ข้อมูลแล้ว!",
                            icon: "success",
                            timer: '1500'
                        })
                    }
                },
				error: function(error){
                    console.log(error)
                }
            });
        });

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
                        url: "{{ url('user') }}" + '/' + id,
                        type: "POST",
                        data: {'_method' : 'DELETE', '_token' : csrf_token},
                        success: function(data) {
                            var oTable = $('#user').dataTable();
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