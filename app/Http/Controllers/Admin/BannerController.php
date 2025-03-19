<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'banners' => Banner::latest('id')->get(),
        ];

        return view('admin.pages.banner.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'nullable',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'badge'       => 'nullable|string|max:191',
            'button_name' => 'nullable|string|max:200',
            'url'         => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ], );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $files = [
                'image' => $request->file('image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath            = 'banner/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Create the Offer model instance
            Banner::create([

                'name'        => $request->name,
                'badge'       => $request->badge,
                'button_name' => $request->button_name,
                'url'         => $request->url,
                'status'      => $request->status,

                'image'       => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
            ]);

            DB::commit();
            return redirect()->route('admin.banner.index')->with('success', 'Data created successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the Offer: ' . $e->getMessage());
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
            'banner' => Banner::findOrFail($id),
        ];
        return view('admin.pages.banner.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'nullable',
            'image'       => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'badge'       => 'nullable|string|max:191',
            'button_name' => 'nullable|string|max:200',
            'url'         => 'nullable|string',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $banner = Banner::findOrFail($id);

            $files = [
                'image' => $request->file('image'),
            ];

            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath = 'banner/' . $key;

                    // Delete old file if exists
                    if ($banner->$key) {
                        Storage::delete($banner->$key);
                    }

                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Update the banner record
            $banner->update([
                'name'        => $request->name,
                'badge'       => $request->badge,
                'button_name' => $request->button_name,
                'url'         => $request->url,
                'status'      => $request->status,
                'image'       => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $banner->image,
            ]);

            DB::commit();
            return redirect()->route('admin.banner.index')->with('success', 'Data updated successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the Offer: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
    }
}
