<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'blogCats' => BlogCategory::latest('id')->get(),
        ];

        return view('admin.pages.blog_cat.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.blog_cat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
                    $filePath            = 'BlogCategory/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            $blogCat = BlogCategory::create([
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

            return redirect()->route('admin.blog_category.index')->with('success', 'Blog Category Create Successfully');
        } catch (\Exception $e) {

            DB::rollback();
            Session::flash('error', 'An error occurred while creating the Brand: ' . $e->getMessage());
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
            'blogCat' => BlogCategory::findOrFail($id),
        ];
        return view('admin.pages.blog_cat.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blogCat = BlogCategory::where('id', $id)->first();

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
                    $filePath = 'BlogCategory/' . $key;
                    $oldFile  = $blogCat->$key ?? null;

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

            // Update the blogCat with the new or existing file paths
            $blogCat->update([
                'name'              => $request->name,

                'logo'              => $uploadedFiles['logo']['status'] == 1 ? $uploadedFiles['logo']['file_path'] : $blogCat->logo,
                'image'             => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $blogCat->image,

                'banner_image'      => $uploadedFiles['banner_image']['status'] == 1 ? $uploadedFiles['banner_image']['file_path'] : $blogCat->banner_image,

                'update_by'         => Auth::guard('admin')->user()->id,

                'short_description' => $request->short_description,
                'description'       => $request->description,

                'status'            => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.blog_category.index')->with('success', 'Blog Category Updated successfully');

        } catch (\Exception $e) {
            return redirect()->route('admin.blog_category.index')->with('error', 'Something Error With Created Blog Category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $blogCat = BlogCategory::findOrFail($id);

        //Delete the image if it exists
        $files = [
            'logo'         => $blogCat->logo,
            'image'        => $blogCat->image,
            'banner_image' => $blogCat->banner_image,
        ];
        foreach ($files as $key => $file) {
            if (! empty($file)) {
                $oldFile = $blogCat->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $blogCat->delete();
    }
}
