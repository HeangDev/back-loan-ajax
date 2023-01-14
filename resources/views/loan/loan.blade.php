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
                        </div>
                        <div class="card-body">
                            
                            <table class="table table-bordered table-striped" id="loan">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ชื่อ</th>
                                        <th>หมายเลขโทรศัพท์</th>
                                        <th>จำนวนเงิน</th>
                                        <th>ดอกเบี้ย</th>
                                        <th>เดื่อน</th>
                                        <th>จำนวนเงินกู้รวมดอกเบี้ย</th>
                                        <th>อัตราจ่ายต่อเดือน</th>
                                        <th>วันที่ยืม</th>
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

    <div id="modal-form-loan" class="modal fade">
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
                    <input type="hidden" id="loan_id" name="loan_id">
                    <div class="form-group">
                        <label>จำนวนเงิน <span style="color: red;">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="amount" id="amount" required>
                    </div>
                    <div class="form-group">
                        <label>ดอกเบี้ย <span style="color: red;">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="interest" id="interest" required>
                    </div>
                    <div class="form-group">
                        <label>จำนวนเงินกู้รวมดอกเบี้ย</label>
                        <input type="text" readonly class="form-control form-control-sm" name="total" id="total">
                    </div>
                    <div class="form-group">
                        <label>อัตราจ่ายต่อเดือน</label>
                        <input type="text" readonly class="form-control form-control-sm" name="pay_month" id="pay_month">
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
        
        var table = $('#loan').DataTable({
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
				url: "{{ route('admin.loan.index') }}",
				type: 'GET',
			},
            
            
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'customer_name', name: 'customer_name'},
                {data: 'customer_tel', name: 'customer_tel'},
				{data: 'amount', name: 'amount'},
                {data: 'interest', name: 'interest'},
                {data: 'duration_month', name: 'duration_month'},
                {data: 'total', name: 'total'},
                {data: 'pay_month', name: 'pay_month'},
				{data: 'date', name: 'date'},
                {data: 'status', name: 'status'},
				{data: 'action', name: 'action', orderable: false},
			],
			order: [[0, 'desc']]
		});

        

        $(function() {
            $('#modal-form-loan form').on('submit', function(e) {
            if (!e.isDefaultPrevented()) {
                var id = $('#loan_id').val();
                $.ajax({
                    url: "{{ url('loan') . '/' }}" + id,
                    type: "POST",
                    data: $('#modal-form-loan form').serialize(),
                    success: function(data) {
                        $('#modal-form-loan').modal('hide');
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

        function editData(id) {
            save_method = 'edit';
            $('input[name=_method]').val('PATCH');
            $('#modal-form-loan form')[0].reset();
            $.ajax({
                url: "{{ url('loan') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#modal-form-loan').modal('show');
                    $('.modal-title').text('แก้ไขระยะเวลา');
                    $('#loan_id').val(data.id);
                    $('#amount').val(data.amount);
                    $('#interest').val(data.interest);
                    $('#total').val(data.total);
                    $('#pay_month').val(data.pay_month);
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
                        url: "{{ url('loan') }}" + '/' + id,
                        type: "POST",
                        data: {'_method' : 'DELETE', '_token' : csrf_token},
                        success: function(data) {
                            var oTable = $('#loan').dataTable();
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