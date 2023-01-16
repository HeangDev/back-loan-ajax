@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">เงินฝาก</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">เงินฝาก</li>
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
                            <h4 class="card-title float-left">เงินฝาก</h4>
                            <a id="adddeposit" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> เพิ่มเงินฝาก</a>
                        </div>
                        <div class="card-body">
                            <input type="hidden" value="{{ $deposit->id_customer }}" name="id_customer" id="id_customer">
                            <table class="table table-bordered table-striped" id="deposit">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>รหัสถอนเงิน</th>
                                        <th>จำนวนเงิน</th>
                                        <th>คำอธิบาย</th>
                                        <th>วันที่ฝาก</th>
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

    <div id="modal-form-deposit" class="modal fade">
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
                    <input type="hidden" id="deposit_id" name="deposit_id">
                    <input type="hidden" value="{{ $deposit->id_customer }}" name="id_customer" id="id_customer">
                    <div class="form-group">
                        <label>รหัสถอนเงิน <span style="color: red;">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="withdrawCode" id="withdrawCode">
                    </div>
                    <div class="form-group">
                        <label>จำนวนเงิน <span style="color: red;">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="amount" id="amount">
                    </div>
                    <div class="form-group">
                        <label>คำอธิบาย</label>
                        <textarea rows="2" class="form-control" name="description" id="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success btn-sm btn-save">ยืนยั่น</button>
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
        var table = $('#deposit').DataTable({
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
				url: "{{ url('deposit') . '/' }}" + id,
				type: 'GET',
			},
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{data: 'withdraw_code', name: 'withdraw_code'},
				{data: 'deposit_amount', name: 'deposit_amount'},
				{
					data: 'description',
					name: 'description',
					render: function(data, type, full, meta) {
						if (data == '') {
							return "-";
						} else {
							return data;
						}
					},
				},
                {data: 'deposit_date', name: 'deposit_date'},
				{data: 'action', name: 'action', orderable: false},
			],
			order: [[0, 'desc']]
		});

        $('#adddeposit').click(function() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modal-form-deposit').modal('show');
            $('#modal-form-deposit form')[0].reset();
            $('.modal-title').text('เพิ่มเงินฝาก');
        });

        $(function() {
            $('#modal-form-deposit form').on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                var id = $('#deposit_id').val();
                if (save_method == 'add') url = "{{ url('deposit') }}";
                else url = "{{ url('deposit') . '/' }}" + id;
                $.ajax({
                    url: url,
                    type: "POST",
                    data: $('#modal-form-deposit form').serialize(),
                    success: function(data) {
                        $('#modal-form-deposit').modal('hide');
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
                url: "{{ url('deposit') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form-deposit').modal('show');
                    $('.modal-title').text('แก้ไขยอกเงิน');
                    $('#deposit_id').val(data.id);
                    $('#withdrawCode').val(data.withdraw_code);
                    $('#amount').val(data.deposit_amount);
                    $('#description').val(data.description);
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
                        url: "{{ url('deposit') }}" + '/' + id,
                        type: "POST",
                        data: {'_method' : 'DELETE', '_token' : csrf_token},
                        success: function(data) {
                            var oTable = $('#deposit').dataTable();
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