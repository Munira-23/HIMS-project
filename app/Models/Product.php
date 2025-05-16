<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'product_name',
        'category_id',
         'quantity',
         'expiry_date'
    ];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
 
public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

}
