<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'staffs' => Admin::latest('id')->get(),
        ];

        return view('admin.pages.staff.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.staff.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request data
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => 'nullable|string|max:255|unique:admins,username',
            'email'        => 'required|email|unique:admins,email',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:255',
            'country'      => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'zipcode'      => 'nullable|string|max:10',
            'biometric_id' => 'nullable|string|max:50',
            'designation'  => 'nullable|string|max:255',
            'status'       => 'required|in:active,inactive',
            'password'     => 'required|string|min:8|confirmed',
            'photo'        => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
        ]);

        // Create new Admin instance
        $admin = new Admin();
        $admin->fill($validated);
        $admin->password = Hash::make($request->password);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Delete old photo if exists
            if ($admin->photo) {
                Storage::delete('public/admin_images/' . $admin->photo);
            }

            // Store new photo
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/admin_images', $filename);
            $admin->photo = $filename;
        }

        // Save admin record
        $admin->save();

        // Redirect with success message
        return redirect()->route('admin.staff.index')->with('success', 'Staff profile created successfully.');
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
            'staff' => Admin::findOrFail($id),
        ];
        return view('admin.pages.staff.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => 'nullable|string|max:255|unique:admins,username,' . $admin->id,
            'email'        => 'required|email|unique:admins,email,' . $admin->id,
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:255',
            'country'      => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:255',
            'zipcode'      => 'nullable|string|max:10',
            'biometric_id' => 'nullable|string|max:50',
            'designation'  => 'nullable|string|max:255',
            'status'       => 'required|in:active,inactive',
            // 'password'     => 'nullable|string|min:8|confirmed',
            'photo'        => 'nullable|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
        ]);

        $admin->fill($validated);

        // if ($request->filled('password')) {
        //     $admin->password = Hash::make($request->password);
        // }

        if ($request->hasFile('photo')) {
            Storage::delete('public/admin_images/' . $admin->photo);
            $filename = time() . '_' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('public/admin_images', $filename);
            $admin->photo = $filename;
        }

        $admin->save();

        return redirect()->route('admin.staff.index')->with('success', 'Staff profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $staff = Admin::findOrFail($id);

        // Delete the staff's profile picture if it exists
        if ($staff->photo) {
            Storage::delete('public/admin_images/' . $staff->photo);
        }

        // Delete the staff record from the database
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
}
