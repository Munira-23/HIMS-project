<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\StockUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $title = 'dashboard';

        // ✅ Key Inventory Insights
        $total_purchases = Purchase::where('expiry_date', '!=', Carbon::now())->count();
        $total_categories = Category::count();
        $total_stock = Product::sum('quantity'); // Total Available Stock
        $low_stock_count = Product::where('quantity', '<', 10)->count(); // Products below threshold
        $expiring_soon = Product::where('expiry_date', '>=', now()) // Expiry date greater than or equal to today
    ->where('expiry_date', '<', now()->addDays(90)) // Expiring within the next 3 months (90 days)
    ->count();


    $total_expired_products = Product::where('expiry_date', '<', now()) // Products already expired
                                      ->count();

        // ✅ Graph: Restocked vs. Used Items
        $restocked_items = Purchase::sum('quantity'); // Total restocked items
        $used_items = StockUsage::sum('quantity_used'); // ✅ Correct column name


        $inventoryChart = app()->chartjs
            ->name('inventoryChart')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Restocked Items', 'Used Items'])
            ->datasets([
                [
                    'label' => 'Inventory Movement',
                    'backgroundColor' => ['#36A2EB', '#FF6384'],
                    'data' => [$restocked_items, $used_items]
                ]
            ])
            ->options([]);

        // ✅ Graph: Expiring Soon vs. Expired
        $expiryChart = app()->chartjs
        

            ->name('expiryChart')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Expiring Soon', 'Expired'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [$expiring_soon, $total_expired_products]
                ]
            ])
            ->options([]);

        // ✅ Recent Stock Restocking & Usage Table
        $recent_restocking = Purchase::latest()->take(5)->get(); // Latest 5 restocked items
        $recent_usage = Product::latest()->take(5)->get(); // Latest 5 used items

        return view('admin.dashboard', compact(
            'title', 'total_expired_products', 'total_categories', 'total_stock', 'low_stock_count',
            'inventoryChart', 'expiryChart', 'recent_restocking', 'recent_usage'
        ));
    }
}
