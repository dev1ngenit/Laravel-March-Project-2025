<?php
namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, HasSlug;

    protected $slugSourceColumn = 'name';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function blogCat()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'added_by');
    }
}
