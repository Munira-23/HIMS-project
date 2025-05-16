<?php

namespace App\Models;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',  // Changed from product_name to product_id for correct foreign key usage
        'product_name',
        'category_id',
        'supplier_id',
        'department',
        'cost_price',
        'quantity',
        'quantity_used', // Added to support stock usage
        'remarks', // Added to store usage notes
        'image'
    ];

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');  // Corrected foreign key usage
    }

    // Relationship with Supplier
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}