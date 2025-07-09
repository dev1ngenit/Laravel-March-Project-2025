<?php
namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasSlug;

    protected $slugSourceColumn = 'name';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'added_by');
    }

    public function categories()
    {
        return Category::whereIn('id', $this->category_id)->get();
    }


    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class,'product_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'published');
    }

}
