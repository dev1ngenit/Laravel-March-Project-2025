<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Mail\ProductCreated;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\ProductRequest;
use App\Notifications\ProductCreatedNotification;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'products' => Product::latest('id')->get(),
        ];

        return view('admin.pages.product.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'brands'        => Brand::latest('id')->where('status', 'active')->get(),
            'parentCategories' => Category::latest('id')->where('status', 'active')->whereNull('parent_id')->get(),
            'subCategories' => Category::latest('id')->where('status', 'active')->whereNotNull('parent_id')->get(),
        ];

        return view('admin.pages.product.create', $data);
    }


    public function store(ProductRequest $request)
    {
        // dd($request->all());

        DB::beginTransaction();

        try {
            $files = [
                'thumbnail_image' => $request->file('thumbnail_image'),
                'thumbnail_image_2' => $request->file('thumbnail_image_2'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath            = 'product/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            $product = Product::create([
                // Relationships
                'brand_id'           => $request->brand_id,
                'category_id'        => $request->category_id,
                'sub_category_id'    => $request->sub_category_id,
                'child_category_id'  => $request->child_category_id,

                // Basic Info
                'name'               => $request->name,
                'sku'                => $request->sku,
                'mf_code'            => $request->mf_code,
                'product_code'       => $request->product_code,
                'barcode_id'         => $request->barcode_id,
                'barcode'            => $request->barcode,

                // Descriptions
                'short_description'  => $request->short_description,
                'long_description'   => $request->long_description,
                'specification'      => $request->specification,

                // Multimedia
                'thumbnail_image'    => $uploadedFiles['thumbnail_image']['status'] == 1 ? $uploadedFiles['thumbnail_image']['file_path'] : null,
                'thumbnail_image_2'  => $uploadedFiles['thumbnail_image_2']['status'] == 1 ? $uploadedFiles['thumbnail_image_2']['file_path'] : null,
                'video_link'         => $request->video_link,

                // Tags and Attributes
                'tags'               => $request->input('tags'),
                'accessories'        => json_encode($request->accessories), // assuming input
                // 'color'              => json_encode($request->color), // not defined in schema, but can be custom if used in your model


                // Stock & Inventory
                'qty'                => $request->qty, // changed from 'stock' to 'qty'

                // Pricing
                'price'              => $request->price ?? 0.00,
                'partner_price'      => $request->partner_price,
                'discount_price'     => $request->discount_price,
                'currency'           => $request->currency,

                // Tax & Warranty
                'vat'                => $request->vat,
                'tax'                => $request->tax,
                'warranty'           => $request->warranty,

                // Dimensions & Weight
                'length'             => $request->length,
                'width'              => $request->width,
                'height'             => $request->height,
                'weight'             => $request->weight,

                // Location & Supplier
                'supplier'           => $request->supplier,
                'warehouse_location' => $request->warehouse_location,

                // Flags
                'is_featured'        => $request->boolean('is_featured'),
                'is_selling'         => $request->boolean('is_selling'),
                'is_refurbished'     => $request->boolean('is_refurbished'),
                'is_new'             => $request->boolean('is_new'),
                'hot_deal'           => $request->boolean('hot_deal'),

                // Rating & Status
                'rating'             => $request->rating,
                'status'             => $request->status,
                'product_type'       => $request->product_type,

                // SEO
                'meta_title'         => $request->meta_title,
                'meta_keywords'      => json_encode($request->meta_keywords),
                'meta_keyword'       => $request->meta_keyword,
                'meta_content'       => $request->meta_content,
                'meta_description'   => $request->meta_description,

                // Admin tracking
                'added_by'           => Auth::guard('admin')->user()->id,
                'created_by'         => Auth::guard('admin')->user()->name ?? null,
                'create_date'        => now()->toDateString(),
            ]);


            if ($request->has('productMediaColor')) {
                // dd($request->productMediaColor);
                foreach ($request->productMediaColor as $media) {
                    if (isset($media['product_color']) && isset($media['multi_images']) && $media['multi_images']) {
                        $productColor = $media['product_color'];
                        $productColorName = $media['color_name'];
                        $productColorPrice = $media['color_price'];
                        $image = $media['multi_images'];

                        // Check if the image exists and upload it
                        if ($image && $image instanceof \Illuminate\Http\UploadedFile) {
                            try {
                                $multiImageUpload = customUpload($image, 'products/multi_images');

                                if ($multiImageUpload['status'] === 0) {
                                    throw new \Exception($multiImageUpload['error_message']);
                                }

                                // Create the product image record
                                ProductImage::create([
                                    'product_id' => $product->id,
                                    'photo'      => $multiImageUpload['file_path'],
                                    'color'      => $productColor,
                                    'color_name' => $productColorName,
                                    'price'      => $productColorPrice,
                                    'created_by' => Auth::guard('admin')->user()->id,
                                ]);
                                // dd($request->all());
                            } catch (\Exception $e) {
                                // Handle any error that occurs during the upload process
                                DB::rollback();
                                return redirect()->back()->withInput()->with('error', 'Error uploading image for color ' . $productColor . ': ' . $e->getMessage());
                            }
                        }
                    }
                }
            }

            DB::commit();

            //Send Notification
            $admins = Admin::where('mail_status', 'mail')->where('status', 'active')->get();

            foreach ($admins as $admin) {
                $admin->notify(new ProductCreatedNotification($product));
            }
            //Send Notification

            // Mail Send
            $admins = Admin::where('mail_status', 'mail')->where('status', 'active')->get();

            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new ProductCreated($product));
            }
            // Mail End

            return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'An error occurred while creating the Product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'product'          => Product::with('images')->findOrFail($id),
            'products'         => Product::latest('id')->where('status', 'active')->get(['id', 'name']),
            'brands'           => Brand::latest('id')->where('status', 'active')->get(),
            'parentCategories' => Category::latest('id')->where('status', 'active')->whereNull('parent_id')->get(),
            'subCategories'    => Category::latest('id')->where('status', 'active')->whereNotNull('parent_id')->get(),
        ];
        return view('admin.pages.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate input data
        $validator = Validator::make(
            $request->all(),
            [
                'name'              => 'required|string|max:200|unique:brands,name,' . $id, // Exclude the current product ID from uniqueness check
                'thumbnail_image'   => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
                'short_description' => 'nullable|string',
                'description'       => 'nullable|string',
                'status'            => 'required|in:active,inactive',
            ],
            [
                'name.required'            => 'The name field is required.',
                'name.unique'              => 'The name has already been taken.',
                'name.max'                 => 'The name may not be greater than 200 characters.',
                'thumbnail_image.file'     => 'The image must be a valid file.',
                'thumbnail_image.mimes'    => 'The image must be a file of type: webp, jpeg, png, jpg.',
                'thumbnail_image.max'      => 'The image may not be greater than 2MB.',
                'status.required'          => 'The status field is required.',
                'status.in'                => 'The selected status is invalid. It must be either active or inactive.',
                'short_description.string' => 'The short description must be a valid string.',
                'description.string'       => 'The description must be a valid string.',
            ]
        );

        // If validation fails, return to the previous page with error messages
        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Session::flash('error', $message);
            }
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();

        try {
            // Get the product to update
            $product = Product::findOrFail($id);

            // Handle the file upload for thumbnail_image
            $files = [
                'thumbnail_image' => $request->file('thumbnail_image'),
                'thumbnail_image_2' => $request->file('thumbnail_image_2'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $oldFile = $product->$key ?? null;
                    if ($oldFile) {
                        Storage::delete("public/" . $oldFile);
                    }
                    $filePath            = 'product/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Update the product in the database
            $product->update([
                // Relationships
                'brand_id'           => $request->brand_id,
                'category_id'        => $request->category_id,
                'sub_category_id'    => $request->sub_category_id,
                'child_category_id'  => $request->child_category_id,

                // Basic Info
                'name'               => $request->name,
                'sku'                => $request->sku,
                'mf_code'            => $request->mf_code,
                'product_code'       => $request->product_code,
                'barcode_id'         => $request->barcode_id,
                'barcode'            => $request->barcode,

                // Descriptions
                'short_description'  => $request->short_description,
                'long_description'   => $request->long_description,
                'specification'      => $request->specification,

                // Multimedia
                'thumbnail_image'    => $uploadedFiles['thumbnail_image']['status'] == 1 ? $uploadedFiles['thumbnail_image']['file_path'] : $product->thumbnail_image,
                'thumbnail_image_2'  => $uploadedFiles['thumbnail_image_2']['status'] == 1 ? $uploadedFiles['thumbnail_image_2']['file_path'] : $product->thumbnail_image_2,
                'video_link'         => $request->video_link,

                // Tags and Attributes
                'tags'               => $request->input('tags'),
                'accessories'        => $request->input('accessories'),
                // 'color'              => json_encode($request->color), // not defined in schema, but can be custom if used in your model


                // Stock & Inventory
                'qty'                => $request->qty, // changed from 'stock' to 'qty'

                // Pricing
                'price'              => $request->price ?? 0.00,
                'partner_price'      => $request->partner_price,
                'discount_price'     => $request->discount_price,
                'currency'           => $request->currency,

                // Tax & Warranty
                'vat'                => $request->vat,
                'tax'                => $request->tax,
                'warranty'           => $request->warranty,

                // Dimensions & Weight
                'length'             => $request->length,
                'width'              => $request->width,
                'height'             => $request->height,
                'weight'             => $request->weight,

                // Location & Supplier
                'supplier'           => $request->supplier,
                'warehouse_location' => $request->warehouse_location,

                // Flags
                'is_featured'        => $request->boolean('is_featured'),
                'is_selling'         => $request->boolean('is_selling'),
                'is_refurbished'     => $request->boolean('is_refurbished'),
                'is_new'             => $request->boolean('is_new'),
                'hot_deal'           => $request->boolean('hot_deal'),

                // Rating & Status
                'rating'             => $request->rating,
                'status'             => $request->status,
                'product_type'       => $request->product_type,

                // SEO
                'meta_title'         => $request->meta_title,
                'meta_keywords'      => json_encode($request->meta_keywords),
                'meta_keyword'       => $request->meta_keyword,
                'meta_content'       => $request->meta_content,
                'meta_description'   => $request->meta_description,
                // 'updated_by'         => Auth::guard('admin')->user()->id,
            ]);

            if ($request->has('productMediaColor')) {
                // dd($request->productMediaColor);
                foreach ($request->productMediaColor as $media) {
                    if (isset($media['product_color']) && isset($media['multi_images']) && $media['multi_images']) {
                        $productColor = $media['product_color'];
                        $productColorName = $media['color_name'];
                        $productColorPrice = $media['color_price'];
                        $image = $media['multi_images'];

                        // Check if the image exists and upload it
                        if ($image && $image instanceof \Illuminate\Http\UploadedFile) {
                            try {
                                $multiImageUpload = customUpload($image, 'products/multi_images');

                                if ($multiImageUpload['status'] === 0) {
                                    throw new \Exception($multiImageUpload['error_message']);
                                }

                                // Create the product image record
                                ProductImage::create([
                                    'product_id' => $product->id,
                                    'photo'      => $multiImageUpload['file_path'],
                                    'color'      => $productColor,
                                    'color_name' => $productColorName,
                                    'price'      => $productColorPrice,
                                    'created_by' => Auth::guard('admin')->user()->id,
                                ]);
                                // dd($request->all());
                            } catch (\Exception $e) {
                                // Handle any error that occurs during the upload process
                                DB::rollback();
                                return redirect()->back()->withInput()->with('error', 'Error uploading image for color ' . $productColor . ': ' . $e->getMessage());
                            }
                        }
                    }
                }
            }

            DB::commit();
            // Redirect with success message
            return redirect()->back()->with('success', 'Product updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'An error occurred while updating the Product: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        $files = [
            'thumbnail_image' => $product->thumbnail_image,
            'thumbnail_image_2' => $product->thumbnail_image_2,
        ];

        foreach ($files as $key => $file) {
            if (! empty($file)) {
                $oldFile = $product->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }

        $product->delete();
    }

    public function multiImageUpdate(Request $request, $id)
    {
        // Validate the color input
        $request->validate([
            'color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/', // Example for hex color validation
            'photo' => 'nullable|image|max:2048', // Ensure the uploaded file is an image and under 2MB
        ]);

        $multiImage = ProductImage::findOrFail($id);

        if ($request->hasFile('photo')) {
            // Handle the file upload for the new photo
            $multiImageFile = $request->file('photo');
            $multiImageFilePath = $multiImage->photo;

            // Delete the old image file if it exists
            if ($multiImageFilePath && Storage::exists("public/" . $multiImageFilePath)) {
                Storage::delete("public/" . $multiImageFilePath);
            }

            // Upload the new image
            $multiImageUpload = customUpload($multiImageFile, 'products/multi_images');
        }

        // Update the product image record with the new color and photo
        $multiImage->update([
            'photo'      => $multiImageUpload['file_path'] ?? $multiImage->photo, // Only update photo if it's uploaded
            'color'      => $request->color,
            'color_name' => $request->color_name,
            'price'      => $request->price,
        ]);

        Session::flash('success', 'Image has been updated successfully!');
        return redirect()->back();
    }

    public function multiImageDestroy(string $id)
    {
        $multiImage = ProductImage::findOrFail($id);
        $files = [
            'photo' => $multiImage->photo,
        ];
        foreach ($files as $key => $file) {
            if (!empty($file)) {
                $oldFile = $multiImage->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $multiImage->delete();
    }
}
