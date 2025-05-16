@extends('admin.layouts.app')

@push('page-css')

@endpush

@push('page-header')
<div class="col-sm-12">
	<h3 class="page-title">Edit Restock</h3>
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
		<li class="breadcrumb-item active">Edit </li>
	</ul>
</div>
@endpush

@section('content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
			
			<!-- Edit Supplier -->
			<form method="post" enctype="multipart/form-data" autocomplete="off" action="{{route('purchases.update',$purchase)}}">
				@csrf
				@method("PUT")
			
				<div class="service-fields mb-3">
					<div class="row">
					<div class="col-lg-4"> 
    <div class="form-group">
        <label>Product Name <span class="text-danger">*</span></label>
        <select class="select2 form-select form-control" name="product_name"> 
            <option value="">Select Product</option>
            @foreach ($products as $product)
			<option value="{{ $product->product_name }}">{{ $product->product_name }}</option>
            @endforeach
        </select>
    </div>
</div>

		
						<div class="col-lg-4">
							<div class="form-group">
								<label>Category <span class="text-danger">*</span></label>
								<select class="select2 form-select form-control" name="category_id"> 
									@foreach ($categories as $category)
										<option {{($purchase->category->id == $category->id) ? 'selected': ''}} value="{{$category->id}}">{{$category->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label>Supplier <span class="text-danger">*</span></label>
								<select class="select2 form-select form-control" name="supplier_id"> 
									@foreach ($suppliers as $supplier)
										<option @if($purchase->supplier->id == $supplier->id) selected @endif value="{{$supplier->id}}">{{$supplier->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<div class="service-fields mb-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Cost Price<span class="text-danger">*</span></label>
								<input class="form-control" value="{{$purchase->cost_price}}" type="text" name="cost_price">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Quantity<span class="text-danger">*</span></label>
								<input class="form-control" value="{{$purchase->quantity}}" type="text" name="quantity">
							</div>
						</div>
					</div>
				</div>

				
						
				
				<div class="submit-section">
					<button class="btn btn-success submit-btn" type="submit"style="background-color: #4c9ed1; color: white;" >Submit</button>
				</div>
			</form>
			<!-- /Edit Supplier -->

			</div>
		</div>
	</div>			
</div>
@endsection	
<!-- Visit codeastro.com for more projects -->


@push('page-js')
	<!-- Select2 JS -->
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
@endpush




