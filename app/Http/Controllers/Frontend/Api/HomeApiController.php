<?php

namespace App\Http\Controllers\Frontend\Api;

use App\Models\Brand;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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


    public function AllCategory()
    {
        $admins = DB::table('admins')->pluck('name', 'id');
        $brands = DB::table('brands')->pluck('name', 'id');

        $categories = Category::with('children.products', 'products')
            ->whereNull('parent_id')
            ->get()
            ->filter(function ($category) {
                return !$category->products->isEmpty() || $category->children->some(function ($child) {
                    return !$child->products->isEmpty();
                });
            })
            ->map(function ($category) use ($admins, $brands) {
                return $this->formatCategory($category, $admins, $brands);
            })
            ->values(); // <-- This reindexes the collection and ensures it's a sequential array

        return response()->json([
            'status' => 'success',
            'data'   => $categories->toArray(), // <-- Force to array here
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

    public function AllProduct(Request $request)
    {

        $admins = DB::table('admins')->pluck('name', 'id');
        $brands = DB::table('brands')->pluck('name', 'id');

        $query = Product::with(['category', 'brand'])->where('status', 'active');

        // === Filters ===
        if ($request->has('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('sub_category_id')) {
            $query->where('sub_category_id', $request->sub_category_id);
        }

        if ($request->has('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->has('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->has('is_featured')) {
            $query->where('is_featured', $request->is_featured);
        }

        if ($request->has('is_refurbished')) {
            $query->where('is_refurbished', $request->is_refurbished);
        }

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('stock') && $request->stock == '1') {
            $query->where('qty', '>=', '1');
        }
        if ($request->has('stock') && $request->stock == '0') {
            $query->where('qty', '==', '0');
        }

        // === Sorting ===
        switch ($request->input('sort_by')) {
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'price_low_to_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_to_low':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest(); // default sorting
                break;
        }

        // === Pagination ===
        $perPage = $request->input('per_page', 20);

        /** @var \Illuminate\Pagination\LengthAwarePaginator $products */
        $products = $query->paginate($perPage);


        // Transform each product using formatProduct()
        $products->getCollection()->transform(function ($product) use ($admins, $brands) {
            return $this->formatProduct(
                $product,
                $admins,
                collect(),
                $product->category->name ?? null,
                $brands[$product->brand_id] ?? null
            );
        });

        return response()->json($products);
    }



    // private function formatCategory($category, $admins, $brands)
    // {
    //     $category->description    = html_entity_decode(strip_tags($category->description));
    //     $category->added_by_name  = $admins[$category->added_by] ?? null;
    //     $category->logo           = $category->logo ? url('storage/' . $category->logo) : null;
    //     $category->image          = $category->image ? url('storage/' . $category->image) : null;
    //     $category->banner_image   = $category->banner_image ? url('storage/' . $category->banner_image) : null;

    //     // Format products of this category
    //     if ($category->products) {
    //         $category->products->map(function ($product) use ($admins, $brands, $category) {
    //             return $this->formatProduct($product, $admins, collect(), $category->name, $brands[$product->brand_id] ?? null);
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

    private function formatCategory($category, $admins, $brands)
    {
        $category->description    = html_entity_decode(strip_tags($category->description));
        $category->added_by_name  = $admins[$category->added_by] ?? null;
        $category->logo           = $category->logo ? url('storage/' . $category->logo) : null;
        $category->image          = $category->image ? url('storage/' . $category->image) : null;
        $category->banner_image   = $category->banner_image ? url('storage/' . $category->banner_image) : null;

        // Format and assign only products in this category
        if ($category->products) {
            $category->products = $category->products->map(function ($product) use ($admins, $brands, $category) {
                return $this->formatProduct($product, $admins, collect(), $category->name, $brands[$product->brand_id] ?? null);
            });
        }

        // Filter and format children with products
        if ($category->children) {
            $category->children = $category->children
                ->filter(function ($child) {
                    return !$child->products->isEmpty();
                })
                ->map(function ($child) use ($admins, $brands) {
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
        $product->thumbnail_image_2   = $product->thumbnail_image_2 ? url('storage/' . $product->thumbnail_image_2) : null;
        $product->short_description = html_entity_decode(strip_tags($product->short_description));
        $product->long_description  = html_entity_decode(strip_tags($product->long_description));
        $product->specification     = html_entity_decode(strip_tags($product->specification));
        $product->added_by_name     = $admins[$product->added_by] ?? null;
        $product->category_id_name  = $categoryName;
        $product->brand_id_name     = $brandName;
        unset(
            $product->short_description,
            $product->specification,
            $product->category,
            $product->brand,
            $product->barcode_id,
            $product->barcode,
            $product->video_link,
            $product->vat,
            $product->tax,
            $product->warranty,
            $product->length,
            $product->width,
            $product->height,
            $product->weight,
            $product->supplier,
            $product->warehouse_location,
            $product->rating,
            $product->product_type,
            $product->added_by,
            $product->update_by,
            $product->created_at,
            $product->updated_at,
            $product->updated_at,
        );
        return $product;
    }

    public function productDetails($slug)
    {
        $product = Product::with(['category', 'brand', 'images'])->where('slug', $slug)->first();

        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Product not found',
            ], 404);
        }

        $category = $product->category;

        // Fix the images output


        // Fix file paths
        $product->thumbnail_image   = $product->thumbnail_image ? url('storage/' . $product->thumbnail_image) : null;
        $product->thumbnail_image_2 = $product->thumbnail_image_2 ? url('storage/' . $product->thumbnail_image_2) : null;

        // JSON Decode: Convert JSON strings to usable arrays
        $product->tags = collect($product->tags ?? [])
            ->map(fn($tag) => is_array($tag) ? $tag : ['value' => $tag])
            ->values();
        $product->accessories = Product::whereIn('id', $product->accessories ?? [])
            ->get()
            ->map(function ($accessory) {
                return [
                    'id'              => $accessory->id,
                    'name'            => $accessory->name,
                    'slug'            => $accessory->slug,
                    'price'           => $accessory->price,
                    'thumbnail_image' => $accessory->thumbnail_image ? url('storage/' . $accessory->thumbnail_image) : null,
                ];
            });




        $product->meta_keywords = collect($product->meta_keywords ?? [])
            ->map(fn($kw) => is_array($kw) ? $kw : ['value' => $kw])
            ->values();

        // Add readable fields
        $product->category_name = $category->name ?? null;
        $product->brand_name    = $product->brand->name ?? null;

        // Related products
        $related_products = $category->products()
            ->where('id', '!=', $product->id)
            ->take(15)
            ->get()
            ->map(function ($relatedProduct) use ($category) {
                return $this->formatProduct($relatedProduct, collect(), $category->name, $relatedProduct->brand->name ?? null);
            });

        // Clean up unnecessary fields
        unset(
            $product->short_description,
            $product->specification,
            $product->category,
            $product->brand,
            $product->barcode_id,
            $product->barcode,
            $product->video_link,
            $product->vat,
            $product->tax,
            $product->warranty,
            $product->length,
            $product->width,
            $product->height,
            $product->weight,
            $product->supplier,
            $product->warehouse_location,
            $product->rating,
            $product->product_type
        );

        $product_array = $product->toArray();

        // Overwrite the images field with your cleaned-up version
        $product_array['images'] = $product->images->map(function ($image) {
            return [
                'id'         => $image->id,
                'photo'      => url('storage/' . $image->photo),
                'color'      => $image->color,
                'color_name' => $image->color_name,
                'price'      => $image->price,
            ];
        })->toArray();

        return response()->json([
            'status' => 'success',
            'data'   => [
                'product'          => $product_array,
                'related_products' => $related_products,
            ],
        ]);
    }


    public function categoryDetails($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found',
            ], 404);
        }

        $category->logo = $category->logo ? url('storage/' . $category->logo) : null;
        $category->image = $category->image ? url('storage/' . $category->image) : null;
        $category->banner_image = $category->banner_image ? url('storage/' . $category->banner_image) : null;

        // Format products
        if ($category->products) {
            $category->products->map(function ($product) use ($category) {
                return $this->formatProduct($product, collect(), $category->name, DB::table('brands')->where('id', $product->brand_id)->value('name'));
            });
        }

        return response()->json([
            'status' => 'success',
            'data'   => $category,
        ]);
    }

    public function allFaq()
    {
        $faqs = DB::table('faqs')
            ->select('id', 'question', 'answer', 'order')
            ->where('status', 'active')
            ->orderBy('order')
            ->get()
            ->map(function ($faq) {
                $faq->question = html_entity_decode(strip_tags($faq->question));
                $faq->answer = html_entity_decode(strip_tags($faq->answer));
                return $faq;
            });

        return response()->json([
            'status' => 'success',
            'data'   => $faqs,
            'count'  => $faqs->count(),
        ]);
    }

    public function allTerms()
    {
        $term = DB::table('terms')
            ->select('id', 'title', 'content', 'effective_date', 'expiration_date')
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($term) {
            $term->title = $term->title;
            $term->content = $term->content;
        }

        return response()->json([
            'status' => 'success',
            'data'   => $term,
        ]);
    }
    public function privacyPolicy()
    {
        $term = DB::table('support_policies')
            ->select('id', 'title', 'content', 'effective_date', 'expiration_date')
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($term) {
            $term->title = $term->title;
            $term->content = $term->content;
        }

        return response()->json([
            'status' => 'success',
            'data'   => $term,
        ]);
    }
    public function returnPolicy()
    {
        $term = DB::table('return_policies')
            ->select('id', 'title', 'content', 'effective_date', 'expiration_date')
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($term) {
            $term->title = $term->title;
            $term->content = $term->content;
        }

        return response()->json([
            'status' => 'success',
            'data'   => $term,
        ]);
    }
    public function buyingPolicy()
    {
        $term = DB::table('buying_policies')
            ->select('id', 'title', 'content', 'effective_date', 'expiration_date')
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($term) {
            $term->title = $term->title;
            $term->content = $term->content;
            // $term->title = html_entity_decode(strip_tags($term->title));
            // $term->content = html_entity_decode(strip_tags($term->content));
        }

        return response()->json([
            'status' => 'success',
            'data'   => $term,
        ]);
    }

    
}
