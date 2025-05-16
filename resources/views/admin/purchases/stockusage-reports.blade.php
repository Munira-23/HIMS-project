@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
    
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Stock Usage Reports</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Generate Stock Usage Reports</li>
	</ul>
</div>
<div class="col-sm-5 col">
	<a href="#generate_report" data-toggle="modal" class="btn btn-success float-right mt-2"style="background-color:#6082B6">Generate Report</a>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-md-12">
	
		@isset($stock_usages)
            <!--  Stock Usage Report -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
					
                        <table id="stockusage-table" class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity Used</th>
                                    <th>Remarks</th>
                                    <th>Department</th>
                                    <th>Used By</th>
                                    <th>Date Used</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stock_usages as $stock_usage)
                                    <tr>
                                        <td>{{ $stock_usage->product_name }}</td>
                                        <td>{{ $stock_usage->quantity_used }}</td>
                                        <td>{{ $stock_usage->remarks }}</td>
                                        <td>{{ $stock_usage->department }}</td>
                                        <td>{{ $stock_usage->used_by }}</td>
                                        <td>{{ date_format(date_create($stock_usage->created_at), "d M, Y") }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
						
                    </div>
                </div>
            </div>
            <!-- / Stock Usage Report -->
        @endisset
       
		
	</div>
</div>

<!-- Generate Modal -->
<div class="modal fade" id="generate_report" aria-hidden="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Generate Report</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" action="{{route('stockusage.report')}}">
					@csrf
					<div class="row form-row">
						<div class="col-12">
							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label>From</label>
										<input type="date" name="from_date" class="form-control from_date">
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<label>To</label>
										<input type="date" name="to_date" class="form-control to_date">
									</div>
								</div>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-success btn-block submit_report"style="background-color:#6082B6">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- /Generate Modal -->
@endsection

@push('page-js')
<script>
    $(document).ready(function(){
        $('#stockusage-table').DataTable({
			dom: 'Bfrtip',		
			buttons: [
				{
				extend: 'collection',
				text: '<span style="background-color:#6082B6;color:white;padding:12px 16px;border-radius:10px;">Export Data</span>',
				buttons: [
					{
						extend: 'pdf',
						exportOptions: {
							columns: "thead th:not(.action-btn)"
						}
					},
					{
						extend: 'excel',
						exportOptions: {
							columns: "thead th:not(.action-btn)"
						}
					},
				
					{
						extend: 'print',
						exportOptions: {
							columns: "thead th:not(.action-btn)"
						}
					}
				]
				}
			]
		});
    });
</script>
@endpush
