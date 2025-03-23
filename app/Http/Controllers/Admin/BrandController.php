<?php
namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\BrandCreatedNotification;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [
            'brands' => Brand::latest('id')->get(),
        ];

        return view('admin.pages.brands.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.brands.create');
    }

    //Store
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name'              => 'required|string|max:200|unique:brands,name',

            'logo'              => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'image'             => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'banner_image'      => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',

            'short_description' => 'nullable|string',
            'description'       => 'nullable|string',
            'status'            => 'required|in:active,inactive',
        ], [

            'name.required'     => 'The name field is required.',
            'name.unique'       => 'The name has already been taken.',
            'name.max'          => 'The name may not be greater than 30 characters.',

            'slug.required'     => 'The slug field is required.',
            'slug.unique'       => 'The slug has already been taken.',
            'slug.max'          => 'The slug may not be greater than 40 characters.',

            'logo.file'         => 'The logo must be a file.',
            'image.file'        => 'The image must be a file.',
            'banner_image.file' => 'The banner image must be a file.',

            'status.required'   => 'The status field is required.',
            'status.in'         => 'The selected status is invalid. It must be either active or inactive.',
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
                'logo'         => $request->file('logo'),
                'image'        => $request->file('image'),
                'banner_image' => $request->file('banner_image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath            = 'brands/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            $brand = Brand::create([
                'name'              => $request->name,

                'logo'              => $uploadedFiles['logo']['status'] == 1 ? $uploadedFiles['logo']['file_path'] : null,
                'image'             => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
                'banner_image'      => $uploadedFiles['banner_image']['status'] == 1 ? $uploadedFiles['banner_image']['file_path'] : null,

                'added_by'          => Auth::guard('admin')->user()->id,

                'short_description' => $request->short_description,
                'description'       => $request->description,

                'status'            => $request->status,
            ]);

            DB::commit();

            //Send Notification
            $admins = Admin::where('mail_status', 'mail')->get();

            foreach ($admins as $admin) {
                $admin->notify(new BrandCreatedNotification($brand));
            }
            //Send Notification

            // return response()->json(['success' => true, 'redirect_url' => route('admin.brands.edit', $brand->id)]);
            return redirect()->route('admin.brands.index');
        } catch (\Exception $e) {

            DB::rollback();
            // return response()->json(['success' => false, 'message' => 'An error occurred while creating the Brand: ' . $e->getMessage()]);
            Session::flash('error', 'An error occurred while creating the Brand: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    //Show
    public function show(Brand $brand)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'brand' => Brand::findOrFail($id),
        ];
        return view('admin.pages.brands.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::where('id', $id)->first();

        DB::beginTransaction();

        try {
            $files = [
                'logo'         => $request->file('logo'),
                'image'        => $request->file('image'),
                'banner_image' => $request->file('banner_image'),

            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath = 'brands/' . $key;
                    $oldFile  = $brand->$key ?? null;

                    if ($oldFile) {
                        Storage::delete("public/" . $oldFile);
                    }
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Update the brand with the new or existing file paths
            $brand->update([
                'name'              => $request->name,

                'logo'              => $uploadedFiles['logo']['status'] == 1 ? $uploadedFiles['logo']['file_path'] : $brand->logo,
                'image'             => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $brand->image,

                'banner_image'      => $uploadedFiles['banner_image']['status'] == 1 ? $uploadedFiles['banner_image']['file_path'] : $brand->banner_image,

                'added_by'          => Auth::guard('admin')->user()->id,

                'short_description' => $request->short_description,
                'description'       => $request->description,

                'status'            => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully');

        } catch (\Exception $e) {
            return redirect()->route('admin.brands.index')->with('error', 'Something Error With Created Brand');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //Delete the image if it exists
        $files = [
            'logo'                => $brand->logo,
            'image'               => $brand->image,
            'banner_image'        => $brand->banner_image,
            'middle_banner_left'  => $brand->middle_banner_left,
            'middle_banner_right' => $brand->middle_banner_right,
        ];
        foreach ($files as $key => $file) {
            if (! empty($file)) {
                $oldFile = $brand->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $brand->delete();
    }

}
