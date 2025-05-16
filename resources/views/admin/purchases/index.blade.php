@extends('admin.layouts.app')

<x-assets.datatables />

@push('page-css')
    
@endpush

@push('page-header')
<div class="col-sm-7 col-auto">
	<h3 class="page-title">Restocking</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Restock</li>
	</ul>

</div>

<!-- Button to Open Modal -->
<div class="col-12 text-end mt-2">
    <a href="#" data-bs-toggle="modal" data-bs-target="#stockUsageModal" 
       class="btn btn-success float-right mt-2" style="background-color:#6082B6;">
        Stock Usage
    </a>
</div>

@endpush
<!-- Visit codeastro.com for more projects -->
@section('content')
<div class="row">
	<div class="col-md-12">
	
		<!-- Recent Orders -->
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table id="purchase-table" class="datatable table table-hover table-center mb-0">
						<thead>
							<tr>
								<th>Product Name</th>
								<th>Category</th>
								<th>Supplier</th>
								<th>Purchase Cost</th>
								<th>Quantity</th>
								
								<th class="action-btn">Action</th>
							</tr>
						</thead>
						<tbody>
														
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /Recent Orders -->
		
	</div>
</div>

<!-- Stock Usage Modal -->
<div class="modal fade" id="stockUsageModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="color:black;">
            <div class="modal-header">
                <h5 class="modal-title">Stock Usage</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('purchases.record-stock-usage') }}">
                    @csrf
                    <div class="form-group">
                        <label>Select Product</label>
                        <select name="product_name" class="form-control" required>
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->product_name }}">
                                    {{ $product->product_name }} ({{ $product->quantity }} in stock)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Quantity Used</label>
                        <input type="number" name="quantity_used" class="form-control" required>
                   </div>
                    <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" name="department" id="department" class="form-control" required>
                   </div>


                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-block" style="background-color:#6082B6;">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection	

@push('page-js')
    
<!-- Bootstrap JS (For Bootstrap 5) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {

        var table = $('#purchase-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('purchases.index')}}",
            columns: [
                {data: 'product', name: 'product'},
                {data: 'category', name: 'category'},
                {data: 'supplier', name: 'supplier'},
                {data: 'cost_price', name: 'cost_price'},
                {data: 'quantity', name: 'quantity'},
				
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ] 
			
        });
		
   
    });
</script> 




@endpush