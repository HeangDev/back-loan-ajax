@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customer</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Customer List</li>
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
                            <h4 class="card-title float-left">Customer List</h4>
                            <a href="{{ route('admin.customer.create') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> Add Customer</a>
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
					name: 'name',
					render: function(data, type, full, meta) {
						if (data == '' || data == null) {
							return "ไม่สมบูรณ์";
						} else {
							return data;
						}
					},
				},
				{data: 'tel', name: 'tel'},
				{data: 'deposit_amount', name: 'deposit_amount'},
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
					name: 'sign_status',
					render: function(data, type, full, meta) {
						if (data == '1') {
							return "<span class='badge badge-pill badge-primary'>เซ็นชื่อเรียบร้อยแล้วค่ะ</span>";
						} else {
							return "<span class='badge badge-pill badge-danger'>ยังไม่ได้เซ็นชื่อค่ะ</span>";
						}
					},
				},
				{data: 'deposits_status', name: 'deposits_status'},
				{
					data: 'withdraw_code',
					name: 'withdraw_code',
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
    </script>
@endsection