@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">รีพอร์ตการกู้เงิน</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">รีพอร์ตการกู้เงิน</li>
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
                            <h4 class="card-title float-left">รีพอร์ตการกู้เงิน</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-inline">
                                <label class="my-1 mr-2">วันที่เริ่มต้น: </label>
                                <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="startdate" id="startdate">
                                <label class="my-1 mr-2">วันที่สิ้นสุด: </label>
                                <input type="date" class="form-control form-control-sm my-1 mr-sm-2" name="enddate" id="enddate">
                                <button type="button" class="btn btn-success btn-sm my-1" id="btnshow"><i class="fas fa-search"></i> แสดง</button>
                            </div>
                            <div class="mt-3">
                                <table class="table table-bordered w-100" id="report_loan">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ชื่อ</th>
                                            <th>เบอร์โทร</th>
                                            <th>จำนวนเงิน</th>
                                            <th>ดอกเบี้ย %</th>
                                            <th>เดื่อน</th>
                                            <th>เงินกู้รวมดอกเบี้ย</th>
                                            <th>จ่ายต่อเดือน</th>
                                            <th>วัน</th>
                                            <th>สถานะ</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
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

        var table = $('#report_loan').DataTable({
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
		})

        function loanData(startdate = '', enddate = '') {
            $('#report_loan').DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                lengthChange: false,
                dom: 'Bfrtip',
                buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
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
                    url: "{{ route('admin.report.loan') }}",
                    data:{startdate:startdate, enddate:enddate}
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'customer_tel', name: 'customers.tel'},
                    {
                        data: 'amount',
                        name: 'loans.amount',
                        render: function(data, type, full, meta) {
                            var data = parseFloat(data);
                            return data.toLocaleString('th-TH', {style: 'currency', currency: 'THB'});
                        },
                    },
                    {
                    data: 'duration_percent',
                    name: 'durations.percent',
                    render: function(data, type, full, meta) {
						var data = Number(data / 100);
                        return data.toLocaleString(undefined, {style: 'percent', minimumFractionDigits:2});
					    },
                    },
                    {data: 'duration_month', name: 'durations.month'},
                    {
                    data: 'total',
                    name: 'loans.total',
                    render: function(data, type, full, meta) {
						var data = parseFloat(data);
                        return data.toLocaleString('th-TH', {style: 'currency', currency: 'THB'});
                        },
                    },
                    {
                        data: 'pay_month',
                        name: 'pay_month',
                        render: function(data, type, full, meta) {
                            var data = parseFloat(data);
                            return data.toLocaleString('th-TH', {style: 'currency', currency: 'THB'});
                        },
                    },
                    {
                        data: 'date',
                        name: 'date',
                        render: function (data, type, row) {
                            return data ? moment(data).format('ddd DD/MM/YY') : '';
                        }
                    },
                    {
                        data: 'approved', 
                        name: 'approved.approved',
                        render: function(data, type, full, meta) {
                            if(data == 'yes') {
                                return "<span class='badge badge-pill badge-primary'>อนุมัติแล้ว</span>";
                            } else {
                                return "<span class='badge badge-pill badge-danger'>รอการอนุมัติ</span>";
                            }
                        }
                    },
                ],
                order: [[0, 'desc']]
            }).buttons().container().appendTo('#report_loan_wrapper .col-md-6:eq(0)');
        }

        $('#btnshow').click(function() {
			var startdate = $('#startdate').val();
			var enddate = $('#enddate').val();
			if (startdate == '') {
				swal.fire({
                    title: 'Oops...',
                    text: "Start Date must not be empty!",
                    type: "warning",
                    timer: '1500'
                })
			} else if(enddate == '') {
				swal.fire({
                    title: 'Oops...',
                    text: "End Date must not be empty!",
                    type: "warning",
                    timer: '1500'
                })
			} else {
                table.destroy();
				loanData(startdate, enddate)
			}
		});


</script>
@endsection