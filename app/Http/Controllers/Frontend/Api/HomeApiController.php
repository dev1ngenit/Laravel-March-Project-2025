<?php

namespace App\Http\Controllers\Frontend\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Banner;
use App\Models\AboutUs;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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

    // public function checkoutStore(Request $request)
    // {
    //     ini_set('max_execution_time', 300);

    //     $totalAmount = preg_replace('/[^0-9.]/', '', $request->input('total_amount'));

    //     $validator = Validator::make($request->all(), [
    //         'shipping_first_name' => 'nullable|string|max:255',
    //         'shipping_last_name'  => 'nullable|string|max:255',
    //         'shipping_phone'      => 'required|string|max:20',
    //         'shipping_address_1'  => 'nullable|string|max:255',
    //         'shipping_address_1'  => 'nullable|string|max:255',
    //         'shipping_email'      => 'required|email',
    //         'shipping_state'      => 'nullable|string|max:255',
    //         'shipping_postcode'   => 'nullable|string|max:20',
    //         'order_note'          => 'nullable|string',
    //         'payment_method'      => 'required|in:cod,stripe,paypal',
    //         'sub_total'           => 'required|numeric|min:0',
    //         'total_amount'        => 'required|numeric|min:0',
    //         'shipping_id'         => 'nullable|exists:shipping_methods,id',
    //         'billing_first_name'  => 'nullable|string|max:255',
    //         'billing_last_name'   => 'nullable|string|max:255',
    //         'billing_email'       => 'nullable|email',
    //         'billing_phone'       => 'nullable|string|max:20',
    //         'billing_address_1'   => 'nullable|string|max:255',
    //         'billing_address_2'   => 'nullable|string|max:255',
    //         'billing_state'       => 'nullable|string|max:255',
    //         'billing_country'     => 'nullable|string|max:255',
    //         'billing_postcode'    => 'nullable|string|max:20',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Validation failed',
    //             'errors'  => $validator->errors(),
    //         ], 422);
    //     }

    //     DB::beginTransaction();

    //     try {
    //         // Generate order number
    //         $typePrefix = 'AC';
    //         $year       = date('Y');
    //         $lastCode   = Order::where('order_number', 'like', "{$typePrefix}-{$year}%")->orderBy('id', 'desc')->first();
    //         $newNumber  = $lastCode ? ((int) substr($lastCode->order_number, strlen("{$typePrefix}-{$year}")) + 1) : 1;
    //         $orderNumber = "{$typePrefix}-{$year}{$newNumber}";

    //         $billingAddress  = trim($request->input('billing_address_1') . ' ' . $request->input('billing_address_2'));
    //         $shippingAddress = trim($request->input('shipping_address_1') . ' ' . $request->input('shipping_address_2'));

    //         $order = Order::create([
    //             'order_number'                 => $orderNumber,
    //             'user_id'                      => $request->input('user_id', null),
    //             'sub_total'                    => $request->input('sub_total'),
    //             'coupon'                       => $request->input('coupon', 0),
    //             'discount'                     => $request->input('discount', 0),
    //             'total_amount'                 => $request->input('total_amount', 0),
    //             'quantity'                     => $request->input('quantity', 0),
    //             'shipping_charge'              => $request->input('shipping_charge', 0),
    //             'payment_method'               => $request->input('payment_method'),
    //             'payment_status'               => 'unpaid',
    //             'status'                       => 'pending',
    //             'shipped_to_different_address' => $request->has('ship-address') ? 'yes' : 'no',
    //             'billing_first_name'           => $request->input('billing_first_name'),
    //             'billing_last_name'            => $request->input('billing_last_name'),
    //             'billing_email'                => $request->input('billing_email'),
    //             'billing_phone'                => $request->input('billing_phone'),
    //             'billing_address'              => $billingAddress,
    //             'billing_zipcode'              => $request->input('billing_postcode'),
    //             'billing_state'                => $request->input('billing_state'),
    //             'billing_country'              => $request->input('billing_country'),
    //             'shipping_first_name'          => $request->input('shipping_first_name'),
    //             'shipping_last_name'           => $request->input('shipping_last_name'),
    //             'shipping_email'               => $request->input('shipping_email'),
    //             'shipping_phone'               => $request->input('shipping_phone'),
    //             'shipping_address'             => $shippingAddress,
    //             'shipping_zipcode'             => $request->input('shipping_postcode'),
    //             'shipping_state'               => $request->input('shipping_state'),
    //             'shipping_country'             => $request->input('shipping_country'),
    //             'order_note'                   => $request->input('order_note'),
    //             'created_by'                   => $request->input('user_id', null),
    //             'order_created_at'             => Carbon::now(),
    //             'created_at'                   => Carbon::now(),
    //         ]);

    //         foreach ($request->orderItems as $item) {
    //             OrderItem::create([
    //                 'order_id'      => $order->id,
    //                 'product_id'    => $item->product_id,
    //                 'user_id'       => $request->input('user_id', null),
    //                 'product_name'  => $item->product_name,
    //                 'product_color' => $item->product_color ?? null,
    //                 'product_image' => $item->product_image ?? null,
    //                 'product_sku'   => $item->product_sku ?? null,
    //                 'price'         => $item->price,
    //                 'tax'           => $item->tax ?? 0,
    //                 'quantity'      => $item->qty,
    //                 'subtotal'      => $item->qty * $item->price,
    //             ]);

    //             $product = Product::find($item->product_id);
    //             $product->decrement('qty', $item->qty);
    //         }

    //         DB::commit();


    //         $order = Order::with('orderItems')->find($order->id);
    //         $user  = User::find($request->input('user_id', null));

    //         // Send order email
    //         // try {
    //         //     $setting = Setting::first();
    //         //     Mail::to([$request->shipping_email, $user->email])
    //         //         ->send(new UserOrderMail($user->name, [
    //         //             'order'           => $order,
    //         //             'order_items'     => $order->orderItems,
    //         //             'user'            => $user,
    //         //             'shipping_charge' => $shippingCharge,
    //         //             'shipping_method' => $shippingMethod?->title,
    //         //         ], $setting));
    //         // } catch (\Throwable $e) {
    //         //     Log::error('Failed to send order email: ' . $e->getMessage());
    //         // }

    //         return response()->json([
    //             'status'  => 'success',
    //             'message' => 'Order placed successfully',
    //             'data'    => [
    //                 'order_number' => $order->order_number,
    //                 'order'        => $order,
    //             ],
    //         ], 201);
    //     } catch (\Throwable $e) {
    //         DB::rollBack();
    //         Log::error('CheckoutStore API error: ' . $e->getMessage());

    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Failed to place order',
    //             'error'   => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    public function checkoutStore(Request $request)
    {
        ini_set('max_execution_time', 300);

        $validator = Validator::make($request->all(), [
            // Shipping info
            'shipping_first_name' => 'nullable|string|max:255',
            'shipping_last_name'  => 'nullable|string|max:255',
            'shipping_phone'      => 'required|string|max:20',
            'shipping_email'      => 'required|email',
            'shipping_address_1'  => 'nullable|string|max:255',
            'shipping_address_2'  => 'nullable|string|max:255',
            'shipping_state'      => 'nullable|string|max:255',
            'shipping_country'    => 'nullable|string|max:255',
            'shipping_postcode'   => 'nullable|string|max:20',

            // Billing info
            'billing_first_name' => 'nullable|string|max:255',
            'billing_last_name'  => 'nullable|string|max:255',
            'billing_email'      => 'nullable|email',
            'billing_phone'      => 'nullable|string|max:20',
            'billing_address_1'  => 'nullable|string|max:255',
            'billing_address_2'  => 'nullable|string|max:255',
            'billing_state'      => 'nullable|string|max:255',
            'billing_country'    => 'nullable|string|max:255',
            'billing_postcode'   => 'nullable|string|max:20',

            // Order data
            'payment_method'     => 'required|in:cod,stripe,paypal',
            'sub_total'          => 'required|numeric|min:0',
            'total_amount'       => 'required|numeric|min:0',
            'coupon'             => 'nullable|numeric|min:0',
            'discount'           => 'nullable|numeric|min:0',
            'shipping_charge'    => 'nullable|numeric|min:0',
            'quantity'           => 'required|integer|min:1',
            'order_note'         => 'nullable|string',

            // Items
            'orderItems'                  => 'required|array|min:1',
            'orderItems.*.product_id'     => 'required|exists:products,id',
            'orderItems.*.product_name'   => 'required|string',
            'orderItems.*.product_color'  => 'nullable|string',
            'orderItems.*.product_image'  => 'nullable|string',
            'orderItems.*.product_sku'    => 'nullable|string',
            'orderItems.*.price'          => 'required|numeric|min:0',
            'orderItems.*.qty'            => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $typePrefix  = 'AC';
            $year        = date('Y');
            $lastOrder   = Order::where('order_number', 'like', "{$typePrefix}-{$year}%")
                ->orderBy('id', 'desc')
                ->first();
            $newNumber   = $lastOrder ? ((int) substr($lastOrder->order_number, strlen("{$typePrefix}-{$year}")) + 1) : 1;
            $orderNumber = "{$typePrefix}-{$year}" . str_pad($newNumber, 5, '0', STR_PAD_LEFT);

            $billingAddress  = trim($request->input('billing_address_1') . ' ' . $request->input('billing_address_2'));
            $shippingAddress = trim($request->input('shipping_address_1') . ' ' . $request->input('shipping_address_2'));

            $userId = $request->input('user_id');

            $order = Order::create([
                'order_number'                 => $orderNumber,
                'user_id'                      => $userId,
                'sub_total'                    => $request->input('sub_total'),
                'coupon'                       => $request->input('coupon', 0),
                'discount'                     => $request->input('discount', 0),
                'total_amount'                 => $request->input('total_amount'),
                'quantity'                     => $request->input('quantity'),
                'shipping_charge'              => $request->input('shipping_charge', 0),
                'payment_method'               => $request->input('payment_method'),
                'payment_status'               => 'unpaid',
                'status'                       => 'pending',
                'shipped_to_different_address' => $request->has('ship-address') ? 'yes' : 'no',
                'billing_first_name'           => $request->input('billing_first_name'),
                'billing_last_name'            => $request->input('billing_last_name'),
                'billing_email'                => $request->input('billing_email'),
                'billing_phone'                => $request->input('billing_phone'),
                'billing_address'              => $billingAddress,
                'billing_zipcode'              => $request->input('billing_postcode'),
                'billing_state'                => $request->input('billing_state'),
                'billing_country'              => $request->input('billing_country'),
                'shipping_first_name'          => $request->input('shipping_first_name'),
                'shipping_last_name'           => $request->input('shipping_last_name'),
                'shipping_email'               => $request->input('shipping_email'),
                'shipping_phone'               => $request->input('shipping_phone'),
                'shipping_address'             => $shippingAddress,
                'shipping_zipcode'             => $request->input('shipping_postcode'),
                'shipping_state'               => $request->input('shipping_state'),
                'shipping_country'             => $request->input('shipping_country'),
                'order_note'                   => $request->input('order_note'),
                'created_by'                   => $userId,
                'order_created_at'             => now(),
                'created_at'                   => now(),
            ]);

            foreach ($request->orderItems as $item) {
                $product = Product::lockForUpdate()->find($item['product_id']);

                if (!$product || $product->qty < $item['qty']) {
                    throw new \Exception("Insufficient stock for product: {$item['product_name']}");
                }

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['product_id'],
                    'user_id'       => $userId,
                    'product_name'  => $item['product_name'],
                    'product_color' => $item['product_color'] ?? null,
                    'product_image' => $item['product_image'] ?? null,
                    'product_sku'   => $item['product_sku'] ?? null,
                    'price'         => $item['price'],
                    'tax'           => $item['tax'] ?? 0,
                    'quantity'      => $item['qty'],
                    'subtotal'      => $item['qty'] * $item['price'],
                ]);

                $product->decrement('qty', $item['qty']);
            }

            DB::commit();

            $order = Order::with('orderItems')->find($order->id);
            $user  = User::find($userId);

            return response()->json([
                'status'  => 'success',
                'message' => 'Order placed successfully',
                'data'    => [
                    'order_number' => $order->order_number,
                    'order'        => $order,
                ],
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('CheckoutStore API error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to place order',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    //siteInformation
    public function siteInformation()
    {
        $siteInfo = DB::table('settings')->first();

        if (!$siteInfo) {
            return response()->json([
                'status' => 'error',
                'message' => 'Site information not found',
            ], 404);
        }

        // Decode JSON fields
        $siteInfo->site_favicon     = $siteInfo->site_favicon ? url('storage/' . $siteInfo->site_favicon)      : null;
        $siteInfo->site_logo_white  = $siteInfo->site_logo_white ? url('storage/' . $siteInfo->site_logo_white) : null;
        $siteInfo->site_logo_black  = $siteInfo->site_logo_black ? url('storage/' . $siteInfo->site_logo_black) : null;

        return response()->json([
            'status' => 'success',
            'data'   => $siteInfo,
        ]);
    }

    //about-us
    public function aboutUs()
    {
        $aboutUs = AboutUs::latest()->first();

        if (!$aboutUs) {
            return response()->json([
                'status' => 'error',
                'message' => 'About Us information not found',
            ], 404);
        }

        $aboutUs->content = $aboutUs->content;

        return response()->json([
            'status' => 'success',
            'data'   => $aboutUs,
        ]);
    }

    // subscriptionStore
    public function subscriptionStore(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name'  => 'nullable|string|max:255',
            'email' => 'required|email|unique:subscriptions,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Create the subscription
        $subscription = Subscription::create([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription created successfully',
            'data'    => $subscription
        ], 201);
    }
}
