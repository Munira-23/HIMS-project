<?php 

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'products';
       

        if ($request->ajax()) {
            $products = Product::with('category')->latest();
            return DataTables::of($products)
            ->addColumn('product', function ($product) {
                return $product->product_name;
            })
            ->addColumn('category', function ($product) {
                return $product->category ? $product->category->name : 'No Category';
            })
            ->addColumn('quantity', function ($product) {
                return $product->quantity;
            })
            ->addColumn('expiry_date', function ($product) {
                return $product->expiry_date ? date('d M, Y', strtotime($product->expiry_date)) : 'N/A';
            })
                ->addColumn('action', function ($product) {
                    $editBtn = auth()->user()->hasPermissionTo('edit-product')
                    ? '<a href="' . route("products.edit", $product->id) . '" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>'
                    : '';

                $deleteBtn = auth()->user()->hasPermissionTo('destroy-purchase')
                    ? '<a data-id="' . $product->id . '" data-route="' . route('products.destroy', $product->id) . '" href="javascript:void(0)" id="deletebtn" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>'
                    : '';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Return the view for non-AJAX requests
    return view('admin.products.index', compact('title'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'add product';
    $categories = Category::all(); // Fetch all categories
    return view('admin.products.create', compact('title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $request->validate([
            'product_name' => 'required|max:200',
            'category_id' => 'required|exists:categories,id',  // Ensure category ID exists in the categories table
            'quantity' => 'required|integer',
            'expiry_date' => 'required|date',
        ]);

        Product::create([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'quantity' => $request->quantity,
            'expiry_date' => $request->expiry_date,
            
        ]);

        return redirect()->route('products.index')->with('success', 'Product has been added');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $title = 'edit product';
        $categories = Category::all(); // Fetch all categories
        $purchases = Purchase::all(); // Fetch all purchases 
        return view('admin.products.edit', compact('title', 'product', 'categories', 'purchases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|max:200',
            'category_id' => 'required|min:1',
            'quantity' => 'required|integer',
            'expiry_date' => 'nullable|date',
        ]);

        $product->update([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
        ]);
    

        return redirect()->route('products.index')->with('success', 'Product has been updated');
    }
    public function outstock(Request $request)
{
    if ($request->ajax()) {
        $outOfStockProducts = Product::where('quantity', '<=', 5)->with('category')->get();

        return DataTables::of($outOfStockProducts)
            ->addColumn('product_name', function ($product) {
                return $product->product_name; // Ensure this matches the field in your database
            })
            ->addColumn('category', function ($product) {
                return $product->category ? $product->category->name : 'N/A';
            })
            ->addColumn('expiry_date', function ($product) {
                return $product->expiry_date ?? 'N/A';
            })
            ->make(true);
    }

    return view('admin.products.outstock');
}
public function expired(Request $request)
{
    if ($request->ajax()) {

        $expiredProducts = Product::where('expiry_date', '<', now())->with('category')->get();

        return DataTables::of($expiredProducts)
            ->addColumn('product_name', function ($product) {
                return $product->product_name ?? 'N/A';
            })
            ->addColumn('category', function ($product) {
                return $product->category ? $product->category->name : 'N/A';
            })
            ->addColumn('quantity', function ($product) {
                return $product->quantity;
            })
            ->addColumn('expiry_date', function ($product) {
                return $product->expiry_date ?? 'N/A';
            })
            ->make(true); // Ensure this is called to return JSON
    }
    $expiredProducts = Product::where('expiry_date', '<', now())->with('category')->get();
    if ($expiredProducts->isNotEmpty()) {
        $users = \App\Models\User::all();
        foreach ($expiredProducts as $product) {
            foreach ($users as $user) {
                $exists = $user->unreadNotifications()
    ->where('type', \App\Notifications\ProductExpiredNotification::class)
    ->whereRaw("CONVERT(JSON_UNQUOTE(JSON_EXTRACT(data, '$.\"product_name\"')) USING utf8) = ?", [$product->product_name])
    ->exists();

                if (!$exists) {
                    $user->notify(new \App\Notifications\ProductExpiredNotification((object)[
                        'product_name' => $product->product_name,
                        'expiry_date' => $product->expiry_date,
                    ]));
                }
            }
        }
    }
    

    return view('admin.products.expired');
}


public function expiredReport(Request $request) {
    $title = 'Expired Stock Reports';
    $expiredProducts = collect(); // Empty collection when page first loads

    if ($request->isMethod('post')) {
        $this->validate($request, [
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $expiredProducts = Product::whereNotNull('expiry_date') // Ensure expiry_date exists
            ->where('expiry_date', '<=', now()) // Fetch only expired products
            ->whereBetween(DB::raw('DATE(expiry_date)'), [$request->from_date, $request->to_date])
            ->get();
    }

    return view('admin.products.expired-reports', compact('expiredProducts', 'title'));
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Product::findOrFail($request->id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
