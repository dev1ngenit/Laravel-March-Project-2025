<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            'allCategories' => Category::latest('id')->where('status', 'active')->get(),
        ];

        return view('admin.pages.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name'              => 'required|string|max:200|unique:brands,name',

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
            ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Session::flash('error', $message);
            }
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();

        try {
            $files = [
                'thumbnail_image' => $request->file('thumbnail_image'),
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

            Product::create([

                'name'               => $request->name,
                'category_id'        => $request->category_id,
                'brand_id'           => $request->brand_id,
                'sku'                => $request->sku,
                'mf_code'            => $request->mf_code,

                'short_description'  => $request->short_description,
                'long_description'   => $request->long_description,
                'specification'      => $request->specification,

                'qty'                => $request->qty,
                'currency'           => $request->currency,
                'price'              => $request->price,
                'discount_price'     => $request->discount_price,
                'supplier'           => $request->supplier,

                'warehouse_location' => $request->warehouse_location,
                'weight'             => $request->weight,
                'tags'               => $request->tags,
                'is_featured'        => $request->is_featured ? true : false,
                'is_selling'         => $request->is_selling ? true : false,

                'is_new'             => $request->is_new ? true : false,
                'hot_deal'           => $request->hot_deal ? true : false,
                'status'             => $request->status,
                'meta_title'         => $request->meta_title,

                'meta_content'       => $request->meta_content,
                'meta_description'   => $request->meta_description,

                'thumbnail_image'    => $uploadedFiles['thumbnail_image']['status'] == 1 ? $uploadedFiles['thumbnail_image']['file_path'] : null,
            ]);

            DB::commit();

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
            'product'       => Product::findOrFail($id),
            'brands'        => Brand::latest('id')->where('status', 'active')->get(),
            'allCategories' => Category::latest('id')->where('status', 'active')->get(),
        ];
        return view('admin.pages.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate input data
        $validator = Validator::make($request->all(),
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
            ]);

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

            // Update the product in the database
            $product->update([
                'name'               => $request->name,
                'category_id'        => $request->category_id,
                'brand_id'           => $request->brand_id,
                'sku'                => $request->sku,
                'mf_code'            => $request->mf_code,
                'short_description'  => $request->short_description,
                'long_description'   => $request->long_description,
                'specification'      => $request->specification,
                'qty'                => $request->qty,
                'currency'           => $request->currency,
                'price'              => $request->price,
                'discount_price'     => $request->discount_price,
                'supplier'           => $request->supplier,
                'warehouse_location' => $request->warehouse_location,
                'weight'             => $request->weight,
                'tags'               => $request->tags,
                'is_featured'        => $request->is_featured ? true : false,
                'is_selling'         => $request->is_selling ? true : false,
                'is_new'             => $request->is_new ? true : false,
                'hot_deal'           => $request->hot_deal ? true : false,
                'status'             => $request->status,
                'meta_title'         => $request->meta_title,
                'meta_content'       => $request->meta_content,
                'meta_description'   => $request->meta_description,
                'thumbnail_image'    => $uploadedFiles['thumbnail_image']['status'] == 1 ? $uploadedFiles['thumbnail_image']['file_path'] : $product->thumbnail_image,
            ]);

            DB::commit();

            // Redirect with success message
            return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
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
}
