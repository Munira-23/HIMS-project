@extends('admin.layouts.app')

@push('page-css')

@endpush    

@push('page-header')
<div class="col-sm-12">
    <h3 class="page-title">Edit Product</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit Product</li>
    </ul>
</div>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body custom-edit-service">
                <!-- Edit Product Form -->
                <form method="post" enctype="multipart/form-data" id="update_service" action="{{ route('products.update', $product->id) }}">
                    @csrf
                    @method('PUT') 

                   <!-- Product Name Field (Pre-Filled) -->
<div class="service-fields mb-3">
    <div class="form-group">
        <label for="product_name">Product Name <span class="text-danger">*</span></label>
        <input 
            type="text" 
            id="product_name" 
            name="product_name" 
            class="form-control" 
            value="{{ old('product_name', $product->product_name) }}" 
            required
        >
    </div>
</div>


                    <!-- Category Dropdown (Pre-Selected) -->
                    <div class="service-fields mb-3">
                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <select class="select2 form-select form-control" name="category_id" required>
                                <option value="" disabled>Select a category</option>
                                <option value="6" {{ $product->category_id == 6 ? 'selected' : '' }}>Pharmaceuticals</option>
                                <option value="7" {{ $product->category_id == 7 ? 'selected' : '' }}>Medical Equipment</option>
                                <option value="39" {{ $product->category_id == 39 ? 'selected' : '' }}>Surgical Supplies</option>
                                <option value="9" {{ $product->category_id == 9 ? 'selected' : '' }}>Laboratory Supplies</option>
                                <option value="51" {{ $product->category_id == 51 ? 'selected' : '' }}>General Supplies</option>
                                <option value="52" {{ $product->category_id == 52 ? 'selected' : '' }}>Diagnostics Kit</option>
                                <option value="53" {{ $product->category_id == 53 ? 'selected' : '' }}>Emergency and Trauma Supplies</option>
                                <option value="54" {{ $product->category_id == 54 ? 'selected' : '' }}>Cleaning Supplies</option>
                                

                            </select>
                        </div>
                    </div>

                    <!-- Optional: Quantity Field (Pre-Filled) -->
                    <div class="service-fields mb-3">
                        <div class="form-group">
                            <label for="quantity">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" value="{{ $product->quantity }}" required>
                        </div>
                    </div>

                    <!-- Optional: Expiry Date Field (Pre-Filled) -->
                    <div class="service-fields mb-3">
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control" value="{{ $product->expiry_date }}">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="submit-section">
                        <button class="btn btn-success submit-btn" type="submit" style="background-color: #4c9ed1; color: white;">
                            Save Changes
                        </button>
                    </div>

                </form>
                <!-- /Edit Product Form -->
            </div>
        </div>
    </div>            
</div>
@endsection

@push('page-js')

@endpush
