@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ข้อความหน้าบ้าน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">ข้อความหน้าบ้าน</li>
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
                            <h4 class="card-title float-left">ข้อความหน้าบ้าน</h4>
                            <a id="addmessage" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> ข้อความหน้าบ้าน</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="message">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>หมายเลขโทรศัพท์</th>
                                        <th>จำนวนเงิน</th>
                                        <th>วันที่</th>
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

    <div id="modal-form-message" class="modal fade">
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
                    <input type="hidden" id="message_id" name="message_id">
                    <div class="form-group">
                        <label>หมายเลขโทรศัพท์ <span style="color: red;">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="tel" id="tel" autofocus required>
                    </div>
                    <div class="form-group">
                        <label>จำนวนเงิน <span style="color: red;">*</span></label>
                        <input type="number" class="form-control form-control-sm" name="amount" id="amount" required>
                    </div>
                    <div class="form-group">
                        <label>วันที่ <span style="color: red;">*</span></label>
                        <input type="date" class="form-control form-control-sm" name="date" id="date" required>
                    </div>
                    <div class="form-group">
                        <label>สถานะ</label>
                        <select class="form-control" name="status" id="status">
                            <option value="1">ใช้งาน</option>
                            <option value="0">ปิดการใช้งาน</option>
                        </select>
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

        var table = $('#message').DataTable({
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
				url: "{{ route('admin.message.index') }}",
				type: 'GET',
			},
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{data: 'tel', name: 'tel'},
				{
                    data: 'amount',
                    name: 'amount',
                    render: function(data, type, full, meta) {
						var data = parseFloat(data);
                        return data.toLocaleString('en-IN');
					},
                },
                {data: 'date', name: 'date'},
				{
					data: 'status',
					name: 'status',
					render: function(data, type, full, meta) {
						if (data == '1') {
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

        $('#addmessage').click(function() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form-message').modal('show');
            $('#modal-form-message form')[0].reset();
            $('.modal-title').text('เพิ่มข้อความหน้าแรก');
        });

        $(function() {
            $('#modal-form-message form').on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                var id = $('#message_id').val();
                if (save_method == 'add') url = "{{ url('message') }}";
                else url = "{{ url('message') . '/' }}" + id;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: $('#modal-form-message form').serialize(),
                    success: function(data) {
                        $('#modal-form-message').modal('hide');
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

        function editForm(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form-message form')[0].reset();
            $.ajax({
                url: "{{ url('message') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form-message').modal('show');
                    $('.modal-title').text('ปรับปรุงข้อความหน้าแรก');
                    $('#message_id').val(data.id);
                    $('#tel').val(data.tel);
                    $('#amount').val(data.amount);
                    $('#date').val(data.date);
                    $('#status').val(data.status);
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
                        url: "{{ url('message') }}" + '/' + id,
                        type: "POST",
                        data: {'_method' : 'DELETE', '_token' : csrf_token},
                        success: function(data) {
                            table.ajax.reload();
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