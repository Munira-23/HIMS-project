@extends('admin.layouts.app')

@push('page-css')
    <!-- Chart.js Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/chart.js/Chart.min.css') }}">
@endpush

@push('page-header')
<div class="col-sm-12">
    <h3 class="page-title">Welcome {{ auth()->user()->name }}!</h3>
    <ul class="breadcrumb">
        <li class="breadcrumb-item active">Dashboard</li>
    </ul>
</div>
@endpush

@section('content')
<div class="row">
    <!-- Total Stock Card -->
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-primary border-primary">
                        <i class="fa fa-th-large"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{ $total_stock }}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted">Total Stock</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Categories -->
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-info">
                        <i class="fa fa-th-large"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{ $total_categories }}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted">Available Categories</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Expired Medicines -->
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-danger border-danger">
                        <i class="fe fe-folder"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{ $total_expired_products }}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted">Expired Medicines</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- System Users -->
    <div class="col-xl-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="dash-widget-header">
                    <span class="dash-widget-icon text-warning border-warning">
                        <i class="fe fe-users"></i>
                    </span>
                    <div class="dash-count">
                        <h3>{{ \DB::table('users')->count() }}</h3>
                    </div>
                </div>
                <div class="dash-widget-info">
                    <h6 class="text-muted">System Users</h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graph Reports -->
<div class="row">
    <!-- Inventory Movement Bar Chart -->
    <div class="col-md-6">
        <div class="card card-chart">
            <div class="card-header">
                <h4 class="card-title text-center">Inventory Movement</h4>
            </div>
            <div class="card-body">
                @if(isset($inventoryChart))
                    {!! $inventoryChart->render() !!}
                @else
                    <p class="text-center text-muted">No inventory data available</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Expiring Soon vs. Expired Pie Chart -->
    <div class="col-md-6">
        <div class="card card-chart">
            <div class="card-header">
                <h4 class="card-title text-center">Expiring Soon vs. Expired</h4>
            </div>
            <div class="card-body">
                @if(isset($expiryChart))
                    {!! $expiryChart->render() !!}
                @else
                    <p class="text-center text-muted">No expiry data available</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Stock Restocking & Usage Table -->
<div class="row">
    <!-- Recent Restocked Items -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Stock Restocking</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($recent_restocking as $restock)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $restock->product_name }} ({{ $restock->quantity }})
                            <span class="badge badge-primary badge-pill">{{ $restock->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


@endsection

@push('page-js')
    <!-- Chart.js JavaScript -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endpush
