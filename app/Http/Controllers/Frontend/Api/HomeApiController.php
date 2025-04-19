<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Brand;

class HomeApiController extends Controller
{
    public function homeSliders()
    {
        $data = Banner::where('status', 'active')->latest()->get()->map(function ($slider) {
            $slider->image = url('storage/' . $slider->image); // or Storage::url()
            return $slider;
        });
        return response()->json([
            'status' => 'success',
            'data'   => $data,
            'count'  => $data->count(),
        ]);
    }

    // public function AllCategory()
    // {
    //     $admins = DB::table('admins')->pluck('name', 'id');
    //     $brands = DB::table('brands')->pluck('name', 'id');
    //     $categories = Category::with('children', 'children.products', 'products')->whereNull('parent_id')->get()
    //         ->map(function ($category) use ($admins, $brands) {
    //             // Decode JSON arrays
    //             $category->description       = html_entity_decode(strip_tags($category->description));
    //             // Fetch names from DB (assuming related tables exist)
    //             $category->added_by_name     = DB::table('admins')->where('id', $category->added_by)->value('name');

    //             // Fix image URLs
    //             $category->logo                = url('storage/' . $category->logo);
    //             $category->image               = url('storage/' . $category->image);
    //             $category->banner_image        = url('storage/' . $category->banner_image);
    //             $category->products->map(function ($product) use ($admins, $brands, $category) {
    //                 $product->thumbnail_image   = $product->thumbnail_image ? url('storage/' . $product->thumbnail_image) : null;
    //                 $product->short_description = html_entity_decode(strip_tags($product->short_description));
    //                 $product->long_description  = html_entity_decode(strip_tags($product->long_description));
    //                 $product->specification     = html_entity_decode(strip_tags($product->specification));
    //                 $product->added_by_name     = $admins[$product->added_by] ?? null;
    //                 $product->brand_id_name     = $brands[$product->brand_id] ?? null;
    //                 $product->category_id_name     = $category->name; // Avoid another DB call
    //                 return $product;
    //             });
    //             return $category;
    //         });

    //     return response()->json([
    //         'status' => 'success',
    //         'data'   => $categories,
    //         'count'  => $categories->count(),
    //     ]);
    // }
    // public function AllCategory()
    // {
    //     $admins = DB::table('admins')->pluck('name', 'id');
    //     $brands = DB::table('brands')->pluck('name', 'id');

    //     $categories = Category::with('children', 'children.products', 'products')
    //         ->whereNull('parent_id')
    //         ->get()
    //         ->map(function ($category) use ($admins, $brands) {
    //             return $this->formatCategory($category, $admins, $brands);
    //         });

    //     return response()->json([
    //         'status' => 'success',
    //         'data'   => $categories,
    //         'count'  => $categories->count(),
    //     ]);
    // }

    // private function formatCategory($category, $admins, $brands)
    // {
    //     $category->description    = html_entity_decode(strip_tags($category->description));
    //     $category->added_by_name  = $admins[$category->added_by] ?? null;
    //     $category->logo           = $category->logo ? url('storage/' . $category->logo) : null;
    //     $category->image          = $category->image ? url('storage/' . $category->image) : null;
    //     $category->banner_image   = $category->banner_image ? url('storage/' . $category->banner_image) : null;

    //     // Format products
    //     if ($category->products) {
    //         $category->products->map(function ($product) use ($admins, $brands, $category) {
    //             $product->thumbnail_image   = $product->thumbnail_image ? url('storage/' . $product->thumbnail_image) : null;
    //             $product->short_description = html_entity_decode(strip_tags($product->short_description));
    //             $product->long_description  = html_entity_decode(strip_tags($product->long_description));
    //             $product->specification     = html_entity_decode(strip_tags($product->specification));
    //             $product->added_by_name     = $admins[$product->added_by] ?? null;
    //             $product->brand_id_name     = $brands[$product->brand_id] ?? null;
    //             $product->category_id_name  = $category->name;
    //             return $product;
    //         });
    //     }

    //     // Recursively format children
    //     if ($category->children) {
    //         $category->children->map(function ($child) use ($admins, $brands) {
    //             return $this->formatCategory($child, $admins, $brands);
    //         });
    //     }

    //     return $category;
    // }


    // public function AllBrand()
    // {
    //     // Cache admin names and categories
    //     $admins = DB::table('admins')->pluck('name', 'id');
    //     $categories = DB::table('categories')->pluck('name', 'id');

    //     $brands = Brand::with('products')->get()->map(function ($brand) use ($admins, $categories) {
    //         $brand->description    = html_entity_decode(strip_tags($brand->description));
    //         $brand->added_by_name  = $admins[$brand->added_by] ?? null;

    //         // Fix image URLs
    //         $brand->logo           = $brand->logo ? url('storage/' . $brand->logo) : null;
    //         $brand->image          = $brand->image ? url('storage/' . $brand->image) : null;
    //         $brand->banner_image   = $brand->banner_image ? url('storage/' . $brand->banner_image) : null;

    //         $brand->products->map(function ($product) use ($admins, $categories, $brand) {
    //             $product->thumbnail_image   = $product->thumbnail_image ? url('storage/' . $product->thumbnail_image) : null;
    //             $product->short_description = html_entity_decode(strip_tags($product->short_description));
    //             $product->long_description  = html_entity_decode(strip_tags($product->long_description));
    //             $product->specification     = html_entity_decode(strip_tags($product->specification));
    //             $product->added_by_name     = $admins[$product->added_by] ?? null;
    //             $product->category_id_name  = $categories[$product->category_id] ?? null;
    //             $product->brand_id_name     = $brand->name; // Avoid another DB call
    //             return $product;
    //         });

    //         return $brand;
    //     });

    //     return response()->json([
    //         'status' => 'success',
    //         'brands' => $brands,
    //         'count'  => $brands->count(),
    //     ]);
    // }

    public function AllCategory()
    {
        $admins = DB::table('admins')->pluck('name', 'id');
        $brands = DB::table('brands')->pluck('name', 'id');

        $categories = Category::with('children', 'children.products', 'products')
            ->whereNull('parent_id')
            ->get()
            ->map(function ($category) use ($admins, $brands) {
                return $this->formatCategory($category, $admins, $brands);
            });

        return response()->json([
            'status' => 'success',
            'data'   => $categories,
            'count'  => $categories->count(),
        ]);
    }

    public function AllBrand()
    {
        $admins     = DB::table('admins')->pluck('name', 'id');
        $categories = DB::table('categories')->pluck('name', 'id');

        $brands = Brand::with('products')->get()->map(function ($brand) use ($admins, $categories) {
            return $this->formatBrand($brand, $admins, $categories);
        });

        return response()->json([
            'status' => 'success',
            'brands' => $brands,
            'count'  => $brands->count(),
        ]);
    }

    private function formatCategory($category, $admins, $brands)
    {
        $category->description    = html_entity_decode(strip_tags($category->description));
        $category->added_by_name  = $admins[$category->added_by] ?? null;
        $category->logo           = $category->logo ? url('storage/' . $category->logo) : null;
        $category->image          = $category->image ? url('storage/' . $category->image) : null;
        $category->banner_image   = $category->banner_image ? url('storage/' . $category->banner_image) : null;

        // Format products of this category
        if ($category->products) {
            $category->products->map(function ($product) use ($admins, $brands, $category) {
                return $this->formatProduct($product, $admins, collect(), $category->name, $brands[$product->brand_id] ?? null);
            });
        }

        // Recursively format children
        if ($category->children) {
            $category->children->map(function ($child) use ($admins, $brands) {
                return $this->formatCategory($child, $admins, $brands);
            });
        }

        return $category;
    }

    private function formatBrand($brand, $admins, $categories)
    {
        $brand->description   = html_entity_decode(strip_tags($brand->description));
        $brand->added_by_name = $admins[$brand->added_by] ?? null;
        $brand->logo          = $brand->logo ? url('storage/' . $brand->logo) : null;
        $brand->image         = $brand->image ? url('storage/' . $brand->image) : null;
        $brand->banner_image  = $brand->banner_image ? url('storage/' . $brand->banner_image) : null;

        if ($brand->products) {
            $brand->products->map(function ($product) use ($admins, $categories, $brand) {
                return $this->formatProduct($product, $admins, $categories, $categories[$product->category_id] ?? null, $brand->name);
            });
        }

        return $brand;
    }

    private function formatProduct($product, $admins, $categories, $categoryName = null, $brandName = null)
    {
        $product->thumbnail_image   = $product->thumbnail_image ? url('storage/' . $product->thumbnail_image) : null;
        $product->short_description = html_entity_decode(strip_tags($product->short_description));
        $product->long_description  = html_entity_decode(strip_tags($product->long_description));
        $product->specification     = html_entity_decode(strip_tags($product->specification));
        $product->added_by_name     = $admins[$product->added_by] ?? null;
        $product->category_id_name  = $categoryName;
        $product->brand_id_name     = $brandName;

        return $product;
    }
}
