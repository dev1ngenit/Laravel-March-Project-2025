<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.pages.slider.index', ['sliders' => Slider::latest()->get()]);
    }

    //create
    public function create()
    {
        return view('admin.pages.slider.create');
    }

    //store
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            'url' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

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
                if (!empty($file)) {
                    $filePath = 'slider/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Create the Slider model instance
            Slider::create([
                'status' => $request->status,
                'url' => $request->url,
                'image' => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
            ]);

            DB::commit();
            return redirect()->route('admin.slider.index')->with('success', 'Slider created successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the Slider: ' . $e->getMessage());
        }
    }

    //Edit
    public function edit(string $id)
    {
        $data = [
            'slider' => Slider::findOrFail($id),
        ];
        return view('admin.pages.slider.edit', $data);
    }

    //Update
    public function update(Request $request, string $id)
    {
        $slider = Slider::find($id);

        DB::beginTransaction();

        try {
            $files = [
                'image' => $request->file('image')
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'slider/' . $key;
                    $oldFile = $brand->$key ?? null;

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
            $slider->update([

                'image' => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $slider->image,
                'status' => $request->status,
                'url' => $request->url,

            ]);

            DB::commit();

            return redirect()->route('admin.slider.index')->with('success', 'Slider updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while updating the brand: ' . $e->getMessage());
        }
    }

    //destroy
    public function destroy(string $id)
    {

        $offer = Slider::findOrFail($id);

        // Delete associated files from storage
        $files = ['image'];

        foreach ($files as $file) {
            $filePath = $offer->$file;
            if ($filePath && Storage::exists("public/$filePath")) {
                Storage::delete("public/$filePath");
            }
        }

        // Delete the offer record
        $offer->delete();

    }

    public function updateStatusSlider(Request $request, $id)
    {
        $offer = Slider::findOrFail($id);
        $offer->status = $request->input('status');
        $offer->save();

        return response()->json(['success' => true]);
    }
}
