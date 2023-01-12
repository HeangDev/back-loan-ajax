@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เบิกเงิน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">เบิกเงิน</li>
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
                            <h4 class="card-title float-left">เบิกเงิน</h4>
                            <a href="{{ route('admin.customer.index') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> รายชื่อลูกค้า</a>
                        </div>
                        <div class="card-body">
                            
                            <table class="table table-bordered table-striped" id="withdraw">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>จำนวนเงิน</th>
                                        <th>วันที่ฝาก</th>
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

    <div id="modal-form-withdraw" class="modal fade">
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
                    <input type="hidden" id="withdraw_id" name="withdraw_id">
                    <div class="form-group">
                        <label>จำนวนเงิน <span style="color: red;">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="amount" id="amount">
                    </div>
                    <div class="form-group">
                        <label>สถานะ</label>
                        <input type="text" class="form-control form-control-sm" name="status" id="status">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm btn-save">ประหยัด</button>
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
        var id = $('#id_customer').val();
        var table = $('#withdraw').DataTable({
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
				url: "{{ route('admin.withdraw.index') }}",
				type: 'GET',
			},
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{data: 'withdraw_amount', name: 'withdraw_amount'},
				{data: 'withdraw_date', name: 'withdraw_date'},
                {data: 'status', name: 'status'},
				{data: 'action', name: 'action', orderable: false},
			],
			order: [[0, 'desc']]
		});

        $(function() {
            $('#modal-form-withdraw form').on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                var id = $('#withdraw_id').val();
                $.ajax({
                    url: "{{ url('withdraw') . '/' }}" + id,
                    type: "POST",
                    data: $('#modal-form-withdraw form').serialize(),
                    success: function(data) {
                        $('#modal-form-withdraw').modal('hide');
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
            $('#modal-form-deposit form')[0].reset();
            $.ajax({
                url: "{{ url('withdraw') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form-withdraw').modal('show');
                    $('.modal-title').text('แก้ไขระยะเวลา');
                    $('#withdraw_id').val(data.id);
                    $('#amount').val(data.withdraw_amount);
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
                        url: "{{ url('withdraw') }}" + '/' + id,
                        type: "POST",
                        data: {'_method' : 'DELETE', '_token' : csrf_token},
                        success: function(data) {
                            var oTable = $('#withdraw').dataTable();
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