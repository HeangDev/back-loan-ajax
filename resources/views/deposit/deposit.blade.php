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
                        <textarea rows="2" class="form-control" name="description"></textarea>
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
				url: "{{ route('admin.deposit.index') }}",
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
    </script>
@endsection