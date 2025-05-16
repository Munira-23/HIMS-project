<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StockUsage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\log;
use App\Http\Controllers\Controller;
use QCod\AppSettings\Setting\AppSettings;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {   
        $title = 'purchases';
        $products = Product::all();
        
        if ($request->ajax()) {
            $purchases = Purchase::with(['category', 'supplier', 'product'])->get(); // Removed 'product'
    
            return DataTables::of($purchases)
                ->addColumn('product', function ($purchase) {
                    $image = '';
                    if (!empty($purchase->image)) {
                        $image = '<span class="avatar avatar-sm mr-2">
                            <img class="avatar-img" src="' . asset("storage/purchases/" . $purchase->image) . '" alt="product">
                        </span>';
                    }
                    return $image . ($purchase->product_name ?? 'N/A'); // Directly return the stored product name
                })
                ->addColumn('category', function ($purchase) {
                    return $purchase->category->name ?? 'N/A'; // Handle null category
                })
                ->addColumn('cost_price', function ($purchase) {
                    return settings('app_currency', 'KES') . ' ' . $purchase->cost_price;
                })
                ->addColumn('supplier', function ($purchase) {
                    return $purchase->supplier->name ?? 'N/A'; // Handle null supplier
                })
                ->addColumn('action', function ($row) {
                    $viewbtn = '<a href="' . route("purchases.show", $row->id) . '" class="viewbtn"><button class="btn btn-primary"><i class="fas fa-eye"></i></button></a>';
                    $editbtn = '<a href="' . route("purchases.edit", $row->id) . '" class="editbtn"><button class="btn btn-info"><i class="fas fa-edit"></i></button></a>';
                    $deletebtn = '<a data-id="' . $row->id . '" data-route="' . route('purchases.destroy', $row->id) . '" href="javascript:void(0)" id="deletebtn"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>';
    
                    if (!auth()->user()->hasPermissionTo('view-purchase')) {
                        $viewbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('edit-purchase')) {
                        $editbtn = '';
                    }
                    if (!auth()->user()->hasPermissionTo('destroy-purchase')) {
                        $deletebtn = '';
                    }
    
                    return $viewbtn . ' ' . $editbtn . ' ' . $deletebtn;
                })
                ->rawColumns(['product', 'action'])
                ->make(true);
        }
    
        return view('admin.purchases.index', compact('title', 'products'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'create purchase';
        $categories = Category::get();
        $suppliers = Supplier::get();
        $products = Product::all(); 
        return view('admin.purchases.create', compact('categories', 'suppliers', 'products'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $this->validate($request, [
        'product_name' => 'required|string', // Validate product_name
        'category_id' => 'required|exists:categories,id',
        'cost_price' => 'required|min:1',
        'quantity' => 'required|min:1',
        'supplier_id' => 'required|exists:suppliers,id',
        'image' => 'file|image|mimes:jpg,jpeg,png,gif',
    ]);

    $imageName = null;
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('storage/purchases'), $imageName);
    }

    // Store purchase record
    $purchase = Purchase::create([
        'product_name' => $request->product_name, // Store product_name
        'category_id' => $request->category_id,
        'supplier_id' => $request->supplier_id,
        'cost_price' => $request->cost_price,
        'quantity' => $request->quantity,
        'image' => $imageName,
    ]);

    // Update product stock
    $product = Product::where('product_name', $request->product_name)->first();
    if ($product) {
        $product->quantity += $request->quantity;
        $product->save();
    }

    return redirect()->route('purchases.index')->with('success', "Purchase added successfully!");
}


    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {   

        $title = 'edit purchase';
        $categories = Category::get();
        $suppliers = Supplier::get();
        $products = Product::all();
        return view('admin.purchases.edit',compact(
            'title','purchase','categories','suppliers','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
{
    $this->validate($request, [
        'product_name' => 'required|', 
        'category_id' => 'required|exists:categories,id',
        'cost_price' => 'required|min:1',
        'quantity' => 'required|min:1',
        'supplier_id' => 'required|exists:suppliers,id',
        'image' => 'file|image|mimes:jpg,jpeg,png,gif',
    ]);

    $imageName = $purchase->image;
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('storage/purchases'), $imageName);
    }

    // Update product stock if quantity changes
    if ($purchase->quantity != $request->quantity) {
        $product = Product::find($purchase->product_name);
        if ($product) {
            $product->quantity -= $purchase->quantity; // Subtract old quantity
            $product->quantity += $request->quantity; // Add new quantity
            $product->save();
        }
    }

    $purchase->update([
        'product_name' => $request->product_name,
        'category_id' => $request->category_id,
        'supplier_id' => $request->supplier_id,
        'cost_price' => $request->cost_price,
        'quantity' => $request->quantity,
        'image' => $imageName,
    ]);

    $notifications = notify("Purchase has been updated");
    return redirect()->route('purchases.index')->with($notifications);
}
    

public function show($id)
{
    $purchase = Purchase::findOrFail($id);
    $totalStock = Product::where('product_name', $purchase->product_name)->sum('quantity');

    return view('admin.purchases.show', compact('purchase', 'totalStock'));
}



    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $purchase = Purchase::findOrFail($request->id);

        // Reduce product stock before deleting purchase
        $product = Product::where('product_name', $purchase->product_name)->first();
        if ($product) {
            $product->quantity -= $purchase->quantity;
            $product->save();
        }

        $purchase->delete();

        return response()->json(['success' => 'Purchase deleted successfully!']);
    }   
    public function stockUsage()
{
    $products = Product::all(); // Fetch products for the dropdown
    return view('admin.purchases.stock-usage', compact('products'));
}

public function recordStockUsage(Request $request)
{
    Log::info('Stock Usage Function Triggered', $request->all()); // Debugging log

    $request->validate([
        'product_name' => 'required|exists:products,product_name',
        'quantity_used' => 'required|integer|min:1',
        'department' => 'required|string',
        'remarks' => 'nullable|string'
    ]);

    $product = Product::where('product_name', $request->product_name)->first();

    if ($request->quantity_used > $product->quantity) {
        return redirect()->back()->with('error', 'Quantity used cannot exceed available stock.');
    }

    // Reduce stock
    $product->update(['quantity' => $product->quantity - $request->quantity_used]);


// Check if stock is below threshold
$threshold = 5; // or use $product->low_stock_threshold if defined
if ($product->quantity < $threshold) {
    \Log::info("Low stock alert triggered for product: {$product->product_name} with quantity: {$product->quantity}");
    // Notify all users
    $users = \App\Models\User::all();
    foreach ($users as $user) {
        $user->notify(new \App\Notifications\StockAlertNotification((object)[
            'product' => $product->product_name,
            'quantity' => $product->quantity,
            'image' => $product->image,
        ]));
    }
}

    // Insert into stock_usages table
    DB::table('stock_usages')->insert([
        'product_name'   => $request->product_name,
        'quantity_used'  => $request->quantity_used,
        'department'     => $request->department,
        'remarks'        => $request->remarks,
        'used_by'        => auth()->id(), // Ensure authentication is working
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    Log::info('Stock Usage Data Inserted Successfully');

    return redirect()->back()->with('success', 'Stock usage recorded successfully.');
}


public function stockUsageReport(Request $request)
{
    $title = 'Stock Usage Reports';
    $stock_usages = collect(); // Ensures no data loads initially

    // Check if the request has date filters
    if ($request->isMethod('post')) {
        $this->validate($request, [
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        // Fetch stock usage data within the selected date range
        $stock_usages = StockUsage::whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date])
            ->with('product')
            ->get();

        return view('admin.purchases.stockusage-reports', compact('stock_usages', 'title'));
    }

    // When loading the page for the first time, no data is displayed
    return view('admin.purchases.stockusage-reports', compact('title'));
}



public function reports(Request $request)
    {
        $title = 'purchase reports';
        return view('admin.purchases.reports', compact('title'));
    }

    /**
     * Generate purchase report form post
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function generateReport(Request $request)
    {
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $title = 'purchase reports';
        $purchases = Purchase::whereBetween(DB::raw('DATE(created_at)'), [$request->from_date, $request->to_date])->get();
        return view('admin.purchases.reports', compact('purchases', 'title'));
    }
}