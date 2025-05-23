<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockUsage extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'quantity_used', 'used_by', 'department', 'remarks'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
