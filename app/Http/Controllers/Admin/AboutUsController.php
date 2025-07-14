<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'items' => AboutUs::latest('id')->get(),
        ];

        return view('admin.pages.about-us.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.about-us.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'version'         => 'required|string|max:250',
            'effective_date'  => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:effective_date',
            'status'          => 'required|in:active,inactive',
        ], [
            'title.required'           => 'The title field is required.',
            'title.string'             => 'The title must be a string.',
            'title.max'                => 'The title may not be greater than 255 characters.',

            'content.required'         => 'The content field is required.',
            'content.string'           => 'The content must be a string.',

            'version.required'         => 'The version field is required.',
            'version.string'           => 'The version must be a string.',
            'version.max'              => 'The version may not be greater than 250 characters.',

            'effective_date.date'      => 'The effective date must be a valid date.',

            'expiration_date.date'     => 'The expiration date must be a valid date.',
            'expiration_date.after_or_equal' => 'The expiration date must be after or equal to the effective date.',

            'status.required'          => 'The status field is required.',
            'status.in'                => 'The selected status is invalid. It must be either active or inactive.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }



        $files = [
            'banner_image' => $request->file('banner_image'),
        ];
        $uploadedFiles = [];
        foreach ($files as $key => $file) {
            if (! empty($file)) {
                $filePath            = 'about-us/' . $key;
                $uploadedFiles[$key] = customUpload($file, $filePath);
                if ($uploadedFiles[$key]['status'] === 0) {
                    return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                }
            } else {
                $uploadedFiles[$key] = ['status' => 0];
            }
        }
        // Create and save the new Support & Policy record
        AboutUs::create([
            'title'           => $request->title,
            'banner_image'    => $uploadedFiles['banner_image']['status'] == 1 ? $uploadedFiles['banner_image']['file_path'] : null,
            'profile_pdf'     => $request->profile_pdf,
            'content'         => $request->content,
            'version'         => $request->version,
            'effective_date'  => $request->effective_date,
            'expiration_date' => $request->expiration_date,
            'status'          => $request->status,
        ]);

        // Redirect with a success message
        return redirect()->route('admin.about-us.index')->with('success', 'Buying & Policy created successfully.');
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
            'item' => AboutUs::findOrFail($id),
        ];
        return view('admin.pages.about-us.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate request data
        $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'version'         => 'required|string|max:50',
            'effective_date'  => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:effective_date',
            'status'          => 'required|in:active,inactive',
        ]);

        // Find the existing Support & Policy and update it
        $item = AboutUs::findOrFail($id);
        $files = [
            'banner_image' => $request->file('banner_image'),

        ];
        $uploadedFiles = [];
        foreach ($files as $key => $file) {
            if (! empty($file)) {
                $filePath = 'about-us/' . $key;
                $oldFile  = $item->$key ?? null;

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
        $item->update([
            'title'           => $request->title,
            'banner_image'    => $uploadedFiles['banner_image']['status'] == 1 ? $uploadedFiles['banner_image']['file_path'] : $item->banner_image,
            'profile_pdf'     => $request->profile_pdf,
            'content'         => $request->content,
            'version'         => $request->version,
            'effective_date'  => $request->effective_date,
            'expiration_date' => $request->expiration_date,
            'status'          => $request->status,
        ]);

        // Redirect with success message
        return redirect()->route('admin.about-us.index')->with('success', 'Buying & Policy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = AboutUs::findOrFail($id);
        $files = [
            'banner_image'        => $item->banner_image,
        ];
        foreach ($files as $key => $file) {
            if (! empty($file)) {
                $oldFile = $item->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $item->delete();
    }
}
