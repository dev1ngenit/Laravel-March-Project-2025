<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Notifications\BlogCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'blogs' => Blog::latest('id')->get(),
        ];

        return view('admin.pages.blog.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'blogCats' => BlogCategory::where('status', 'active')->latest('id')->get(),
        ];
        return view('admin.pages.blog.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name'              => 'required|string|max:200|unique:brands,name',
            'blog_category_id'  => 'required',

            'image'             => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'image_one'         => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'image_two'         => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'author_image'      => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'video'             => 'nullable|file|mimes:mp4|max:10048',

            'short_description' => 'nullable|string',
            'status'            => 'required|in:active,inactive',

        ], [

            'name.required'             => 'The name field is required.',
            'name.unique'               => 'The name has already been taken.',
            'name.max'                  => 'The name may not be greater than 30 characters.',

            'blog_category_id.required' => 'The Blog Category field is required.',

            'image.file'                => 'The image must correct formate.',
            'image_one.file'            => 'The image must correct formate.',
            'image_two.file'            => 'The image must correct formate.',
            'author_image.file'         => 'The image must correct formate.',
            'video.file'                => 'The image must correct formate.',

            'status.required'           => 'The status field is required.',
            'status.in'                 => 'The selected status is invalid. It must be either active or inactive.',
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

                'image'        => $request->file('image'),
                'image_one'    => $request->file('image_one'),
                'image_two'    => $request->file('image_two'),
                'video'        => $request->file('video'),
                'author_image' => $request->file('author_image'),
            ];
            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath            = 'Vlog/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            $blog = Blog::create([

                'image'                => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : null,
                'image_one'            => $uploadedFiles['image_one']['status'] == 1 ? $uploadedFiles['image_one']['file_path'] : null,
                'image_two'            => $uploadedFiles['image_two']['status'] == 1 ? $uploadedFiles['image_two']['file_path'] : null,
                'video'                => $uploadedFiles['video']['status'] == 1 ? $uploadedFiles['video']['file_path'] : null,
                'author_image'         => $uploadedFiles['author_image']['status'] == 1 ? $uploadedFiles['author_image']['file_path'] : null,

                'status'               => $request->status,
                'name'                 => $request->name,
                'blog_category_id'     => $request->blog_category_id,
                'date'                 => $request->date,

                'short_description'    => $request->short_description,
                'long_description_one' => $request->long_description_one,
                'long_description_two' => $request->long_description_two,
                'video_description'    => $request->video_description,

                'author_name'          => $request->author_name,
                'quote'                => $request->quote,

                'is_featured'          => $request->is_featured,
                'meta_title'           => $request->meta_title,
                'meta_tags'            => $request->meta_tags,
                'meta_description'     => $request->meta_description,
                'tags'                 => $request->tags,

                'added_by'             => Auth::guard('admin')->user()->id,
            ]);

            DB::commit();

            //Send Notification
            $admins = Admin::where('mail_status', 'mail')->get();

            foreach ($admins as $admin) {
                $admin->notify(new BlogCreatedNotification($blog));
            }
            //Send Notification

            return redirect()->route('admin.blog.index')->with('success', 'Blog Create Successfully');

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
            'blog'     => Blog::findOrFail($id),
            'blogCats' => BlogCategory::where('status', 'active')->latest('id')->get(),
        ];

        return view('admin.pages.blog.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [

            'name'              => 'required|string|max:200|unique:brands,name,' . $id,
            'blog_category_id'  => 'required',

            'image'             => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'image_one'         => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'image_two'         => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'author_image'      => 'nullable|file|mimes:webp,jpeg,png,jpg|max:2048',
            'video'             => 'nullable|file|mimes:mp4|max:10048',

            'short_description' => 'nullable|string',
            'status'            => 'required|in:active,inactive',

        ], [

            'name.required'             => 'The name field is required.',
            'name.unique'               => 'The name has already been taken.',
            'name.max'                  => 'The name may not be greater than 30 characters.',

            'blog_category_id.required' => 'The Blog Category field is required.',

            'image.file'                => 'The image must be of correct format.',
            'image_one.file'            => 'The image must be of correct format.',
            'image_two.file'            => 'The image must be of correct format.',
            'author_image.file'         => 'The image must be of correct format.',
            'video.file'                => 'The video must be of correct format.',

            'status.required'           => 'The status field is required.',
            'status.in'                 => 'The selected status is invalid. It must be either active or inactive.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->messages()->all() as $message) {
                Session::flash('error', $message);
            }
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();

        try {
            $blog = Blog::findOrFail($id); // Retrieve the blog to update

            $files = [

                'image'        => $request->file('image'),
                'image_one'    => $request->file('image_one'),
                'image_two'    => $request->file('image_two'),
                'video'        => $request->file('video'),
                'author_image' => $request->file('author_image'),
            ];

            $uploadedFiles = [];
            foreach ($files as $key => $file) {
                if (! empty($file)) {
                    $filePath            = 'blog/' . $key;
                    $uploadedFiles[$key] = customUpload($file, $filePath);
                    if ($uploadedFiles[$key]['status'] === 0) {
                        return redirect()->back()->with('error', $uploadedFiles[$key]['error_message']);
                    }
                } else {
                    $uploadedFiles[$key] = ['status' => 0];
                }
            }

            $blog->update([

                'image'                => $uploadedFiles['image']['status'] == 1 ? $uploadedFiles['image']['file_path'] : $blog->image,
                'image_one'            => $uploadedFiles['image_one']['status'] == 1 ? $uploadedFiles['image_one']['file_path'] : $blog->image_one,
                'image_two'            => $uploadedFiles['image_two']['status'] == 1 ? $uploadedFiles['image_two']['file_path'] : $blog->image_two,
                'video'                => $uploadedFiles['video']['status'] == 1 ? $uploadedFiles['video']['file_path'] : $blog->video,
                'author_image'         => $uploadedFiles['author_image']['status'] == 1 ? $uploadedFiles['author_image']['file_path'] : $blog->author_image,

                'status'               => $request->status,
                'name'                 => $request->name,
                'blog_category_id'     => $request->blog_category_id,
                'date'                 => $request->date,

                'short_description'    => $request->short_description,
                'long_description_one' => $request->long_description_one,
                'long_description_two' => $request->long_description_two,
                'video_description'    => $request->video_description,

                'author_name'          => $request->author_name,
                'quote'                => $request->quote,

                'is_featured'          => $request->is_featured,
                'meta_title'           => $request->meta_title,
                'meta_tags'            => $request->meta_tags,
                'meta_description'     => $request->meta_description,
                'tags'                 => $request->tags,

                'added_by'             => Auth::guard('admin')->user()->id,
            ]);

            DB::commit();

            return redirect()->route('admin.blog.index')->with('success', 'Blog Updated Successfully');

        } catch (\Exception $e) {

            DB::rollback();
            Session::flash('error', 'An error occurred while updating the Blog: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        //Delete the image if it exists
        $files =

            [

            'image'        => $blog->image,
            'image_one'    => $blog->image_one,
            'image_two'    => $blog->image_two,
            'author_image' => $blog->author_image,
            'video'        => $blog->video,
        ];

        foreach ($files as $key => $file) {
            if (! empty($file)) {
                $oldFile = $blog->$key ?? null;
                if ($oldFile) {
                    Storage::delete("public/" . $oldFile);
                }
            }
        }
        $blog->delete();
    }
}
