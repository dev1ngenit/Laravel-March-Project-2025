<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminProfileController extends Controller
{
   
    //AdminProfile
    public function AdminProfile()
    {
        $id          = Auth::guard('admin')->user()->id;
        $profileData = Admin::find($id);

        $roles = Role::latest()->get();

        return view('admin.pages.profile.admin_profile', compact('profileData', 'roles'));
    }

    //AdminProfileUpdate

    public function AdminProfileUpdate(Request $request)
    {
        $id     = Auth::guard('admin')->user()->id;
        $update = Admin::findOrFail($id);

        $update->name         = $request->name;
        $update->company_name = $request->company_name;
        $update->email        = $request->email;
        $update->phone        = $request->phone;
        $update->address      = $request->address;
        $update->designation  = $request->designation;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Delete old photo if exists
            if ($update->photo) {
                Storage::delete('public/admin_images/' . $update->photo);
            }

            // Store new photo
            $filename      = date('YmdHi') . '_' . $file->getClientOriginalName();
            $path          = $file->storeAs('public/admin_images', $filename);
            $update->photo = $filename;
        }

        $update->save();

        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }

    //Admin Password
    public function AdminPasswordPage()
    {
        $id          = Auth::guard('admin')->user()->id;
        $profileData = Admin::find($id);

        return view('admin.pages.profile.admin_password', compact('profileData'));
    }

    //Admin Password Update
    public function AdminPasswordUpdateSubmit(Request $request)
    {
        //validate
        $request->validate([

            'old_password' => 'required',
            'new_password' => [

                'required', 'confirmed', Rules\Password::min(8)->mixedCase()->symbols()->letters()->numbers(),

            ],
        ]);

        //Match Old Password
        if (! Hash::check($request->old_password, Auth::guard('admin')->user()->password)) {

            return redirect()->back()->with('error', 'Old Password Not Match!');
        }

        //Update New Password
        Admin::whereId(Auth::guard('admin')->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password Change Succeesfully');
    }

    /**
     * Delete the user's account.
     */

    public function destroy(Request $request)
    {
        // $request->validateWithBag('userDeletion', [
        //     'password' => ['required', 'current_password'],
        // ]);

        // Get the authenticated admin user
        $user = $request->user();

        Auth::guard('admin')->logout();

        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // return Redirect::to('/');
        // return redirect('/');
    }
}
