@extends('admin.layouts.app')

@push('page-css')

@endpush    

@push('page-header')
<div class="col-sm-12">
    <h3 class="page-title">Add Product</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Product</li>
    </ul>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body custom-edit-service">
                <!-- Add Product -->
                <form method="post" enctype="multipart/form-data" id="update_service" action="{{route('products.store')}}">
                    @csrf

                    <!-- Product Name Input -->
                    <div class="service-fields mb-3">
                        <div class="form-group">
                            <label>Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="product_name" class="form-control" placeholder="Enter product name" >
                        </div>
                    </div>

                    <!-- Category Dropdown -->
                    <div class="service-fields mb-3">
                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <select class="select2 form-select form-control" name="category_id" required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="6">Pharmaceuticals</option>
                                <option value="7">Medical Equipment</option>
                                <option value="39">Surgical Supplies</option>
                                <option value="9">Laboratory Supplies</option>
                                <option value="51">General Supplies</option>
        
                            </select>
                        </div>
                    </div>

                    <!-- Quantity Input -->
    <div class="mb-3">
        <label>Quantity <span class="text-danger">*</span></label>
        <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" required>
    </div>

    <!-- Expiry Date Input -->
    <div class="mb-3">
        <label>Expiry Date <span class="text-danger">*</span></label>
        <input type="date" name="expiry_date" class="form-control" required>
    </div> 
                    <!-- Submit Button -->
                    <div class="submit-section">
                        <button class="btn btn-success submit-btn" type="submit" style="background-color: #4c9ed1; color: white;">
                            Submit
                        </button>
                    </div>

                </form>
                <!-- /Add Product -->
            </div>
        </div>
    </div>            
</div>
@endsection

@push('page-js')

@endpush
