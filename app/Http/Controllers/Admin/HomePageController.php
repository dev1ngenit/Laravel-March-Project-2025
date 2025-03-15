<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'homePages' => HomePage::latest()->get(),
        ];

        return view('admin.pages.homepage.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.homepage.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        // $validator = Validator::make($request->all(), [

        //     'logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        //     'image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        //     'banner_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',

        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        DB::beginTransaction();

        try {
            $files = [

                'top_banner' => $request->file('top_banner'),
                'deal_brand_image' => $request->file('deal_brand_image'),

                'offer_slider_image_one' => $request->file('offer_slider_image_one'),
                'offer_slider_image_two' => $request->file('offer_slider_image_two'),
                'offer_slider_image_three' => $request->file('offer_slider_image_three'),
                'offer_slider_image_four' => $request->file('offer_slider_image_four'),

                'bottom_banner_slider_one' => $request->file('bottom_banner_slider_one'),
                'bottom_banner_slider_two' => $request->file('bottom_banner_slider_two'),
                'bottom_banner_slider_three' => $request->file('bottom_banner_slider_three'),
                'bottom_banner_slider_four' => $request->file('bottom_banner_slider_four'),

            ];

            $uploadedFiles = [];

            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'homepage/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            // Create the Offer model instance
            HomePage::create([

                'top_banner_link' => $request->top_banner_link,
                'deal_title' => $request->deal_title,
                'deal_header' => $request->deal_header,
                'deal_brand_id' => $request->deal_brand_id,

                'offer_slider_image_one_link' => $request->offer_slider_image_one_link,
                'offer_slider_image_two_link' => $request->offer_slider_image_two_link,
                'offer_slider_image_three_link' => $request->offer_slider_image_three_link,
                'offer_slider_image_four_link' => $request->offer_slider_image_four_link,

                'bottom_banner_slider_one_link' => $request->bottom_banner_slider_one_link,
                'bottom_banner_slider_two_link' => $request->bottom_banner_slider_two_link,
                'bottom_banner_slider_three_link' => $request->bottom_banner_slider_three_link,
                'bottom_banner_slider_four_link' => $request->bottom_banner_slider_four_link,

                'top_banner' => $uploadedFiles['top_banner']['status'] == 1 ? $uploadedFiles['top_banner']['file_path'] : null,

                'deal_brand_image' => $uploadedFiles['deal_brand_image']['status'] == 1 ? $uploadedFiles['deal_brand_image']['file_path'] : null,

                'offer_slider_image_one' => $uploadedFiles['offer_slider_image_one']['status'] == 1 ? $uploadedFiles['offer_slider_image_one']['file_path'] : null,

                'offer_slider_image_two' => $uploadedFiles['offer_slider_image_two']['status'] == 1 ? $uploadedFiles['offer_slider_image_two']['file_path'] : null,

                'offer_slider_image_three' => $uploadedFiles['offer_slider_image_three']['status'] == 1 ? $uploadedFiles['offer_slider_image_three']['file_path'] : null,

                'offer_slider_image_four' => $uploadedFiles['offer_slider_image_four']['status'] == 1 ? $uploadedFiles['offer_slider_image_four']['file_path'] : null,

                'bottom_banner_slider_one' => $uploadedFiles['bottom_banner_slider_one']['status'] == 1 ? $uploadedFiles['bottom_banner_slider_one']['file_path'] : null,

                'bottom_banner_slider_two' => $uploadedFiles['bottom_banner_slider_two']['status'] == 1 ? $uploadedFiles['bottom_banner_slider_two']['file_path'] : null,

                'bottom_banner_slider_three' => $uploadedFiles['bottom_banner_slider_three']['status'] == 1 ? $uploadedFiles['bottom_banner_slider_three']['file_path'] : null,

                'bottom_banner_slider_four' => $uploadedFiles['bottom_banner_slider_four']['status'] == 1 ? $uploadedFiles['bottom_banner_slider_four']['file_path'] : null,

            ]);

            DB::commit();
            return redirect()->route('admin.homepage.index')->with('success', 'Data created successfully');

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
            'homepage' => HomePage::findOrFail($id),
        ];
        return view('admin.pages.homepage.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $homepage = HomePage::find($id);

        DB::beginTransaction();

        try {
            $files = [

                'top_banner' => $request->file('top_banner'),
                'deal_brand_image' => $request->file('deal_brand_image'),

                'offer_slider_image_one' => $request->file('offer_slider_image_one'),
                'offer_slider_image_two' => $request->file('offer_slider_image_two'),
                'offer_slider_image_three' => $request->file('offer_slider_image_three'),
                'offer_slider_image_four' => $request->file('offer_slider_image_four'),

                'bottom_banner_slider_one' => $request->file('bottom_banner_slider_one'),
                'bottom_banner_slider_two' => $request->file('bottom_banner_slider_two'),
                'bottom_banner_slider_three' => $request->file('bottom_banner_slider_three'),
                'bottom_banner_slider_four' => $request->file('bottom_banner_slider_four'),

            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (!empty($file)) {
                    $filePath = 'homepage/' . $key;
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
            $homepage->update([

                'top_banner' => $uploadedFiles['top_banner']['status'] == 1 ? $uploadedFiles['top_banner']['file_path'] : $homepage->top_banner,

                'deal_brand_image' => $uploadedFiles['deal_brand_image']['status'] == 1 ? $uploadedFiles['deal_brand_image']['file_path'] : $homepage->deal_brand_image,

                'offer_slider_image_one' => $uploadedFiles['offer_slider_image_one']['status'] == 1 ? $uploadedFiles['offer_slider_image_one']['file_path'] : $homepage->offer_slider_image_one,

                'offer_slider_image_two' => $uploadedFiles['offer_slider_image_two']['status'] == 1 ? $uploadedFiles['offer_slider_image_two']['file_path'] : $homepage->offer_slider_image_two,

                'offer_slider_image_three' => $uploadedFiles['offer_slider_image_three']['status'] == 1 ? $uploadedFiles['offer_slider_image_three']['file_path'] : $homepage->offer_slider_image_three,

                'offer_slider_image_four' => $uploadedFiles['offer_slider_image_four']['status'] == 1 ? $uploadedFiles['offer_slider_image_four']['file_path'] : $homepage->offer_slider_image_four,

                'bottom_banner_slider_one' => $uploadedFiles['bottom_banner_slider_one']['status'] == 1 ? $uploadedFiles['bottom_banner_slider_one']['file_path'] : $homepage->bottom_banner_slider_one,

                'bottom_banner_slider_two' => $uploadedFiles['bottom_banner_slider_two']['status'] == 1 ? $uploadedFiles['bottom_banner_slider_two']['file_path'] : $homepage->bottom_banner_slider_two,

                'bottom_banner_slider_three' => $uploadedFiles['bottom_banner_slider_three']['status'] == 1 ? $uploadedFiles['bottom_banner_slider_three']['file_path'] : $homepage->bottom_banner_slider_three,

                'bottom_banner_slider_four' => $uploadedFiles['bottom_banner_slider_four']['status'] == 1 ? $uploadedFiles['bottom_banner_slider_four']['file_path'] : $homepage->bottom_banner_slider_four,

                'offer_slider_image_one_link' => $request->offer_slider_image_one_link,
                'offer_slider_image_two_link' => $request->offer_slider_image_two_link,
                'offer_slider_image_three_link' => $request->offer_slider_image_three_link,
                'offer_slider_image_four_link' => $request->offer_slider_image_four_link,

                
                'top_banner_link' => $request->top_banner_link,
                'deal_title' => $request->deal_title,
                'deal_header' => $request->deal_header,
                'deal_brand_id' => $request->deal_brand_id,

                'bottom_banner_slider_one_link' => $request->bottom_banner_slider_one_link,
                'bottom_banner_slider_two_link' => $request->bottom_banner_slider_two_link,
                'bottom_banner_slider_three_link' => $request->bottom_banner_slider_three_link,
                'bottom_banner_slider_four_link' => $request->bottom_banner_slider_four_link,

            ]);

            DB::commit();

            return redirect()->route('admin.homepage.index')->with('success', 'Data Updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while updating the brand: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $offer = HomePage::findOrFail($id);

        // Delete the offer record
        $offer->delete();
    }
}
