@extends('layout.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Agreement</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Agreement List</li>
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
                            <h4 class="card-title float-left">Agreement List</h4>
                            <a href="{{ route('admin.agreement.create') }}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> Add Agreement</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" id="agreement">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
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

        var table = $('#agreement').DataTable({
			responsive: true,
			autoWidth: false,
			processing: true,
			serverSide: true,
			ajax: {
				url: "{{ route('admin.agreement.index') }}",
				type: 'GET',
			},
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{ data: 'title', name: 'title' },
				{
					data: 'status',
					name: 'status',
					render: function(data, type, full, meta) {
						if (data == '1') {
							return "<span class='badge badge-pill badge-primary'>Active</span>";
						} else {
							return "<span class='badge badge-pill badge-danger'>Unactive</span>";
						}
					},
				},
				{data: 'action', name: 'action', orderable: false},
			],
			order: [[0, 'desc']]
		});

        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.value) {
					$.ajax({
                        url: "{{ url('admin/agreement') }}" + '/' + id,
                        type: "POST",
                        data: {'_method' : 'DELETE', '_token' : csrf_token},
                        success: function(data) {
                            var oTable = $('#agreement').dataTable();
							oTable.fnDraw(false);
                            swal.fire({
                                title: 'Success!',
                                text: "Data has been deleted!",
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