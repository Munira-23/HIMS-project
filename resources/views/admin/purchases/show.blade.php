@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>View Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $purchase->product_name }}</h5>

            <p><strong>Category:</strong> {{ $purchase->category->name }}</p>
            <p><strong>Supplier:</strong> {{ $purchase->supplier->name }}</p>
            <p><strong>Quantity Restocked:</strong> {{ $purchase->quantity }}</p>
            <p><strong>Total Stock After Restock:</strong> {{ $totalStock }}</p>
            <p><strong>Cost Price Per Item:</strong> {{ settings('app_currency','KES') . ' ' . $purchase->cost_price }}</p>
            <p><strong>Restocking Date:</strong> {{ $purchase->created_at->format('d M Y, h:i A') }}</p>

            @if($purchase->image)
                <p><strong>Image:</strong></p>
                <img src="{{ asset('storage/purchases/'.$purchase->image) }}" alt="Product Image" class="img-fluid" style="max-width: 200px;">
            @endif

            <a href="{{ route('purchases.index') }}" class="btn btn-primary mt-3" style="background-color: #6082B6; color: white;">Back to Restocking List</a>
        </div>
    </div>
</div>
@endsection
