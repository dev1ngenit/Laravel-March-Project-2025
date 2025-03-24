<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    //AdminProfile
    public function userProfile()
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('user.pages.profile.user_profile', compact('userData'));
    }

    public function userProfileUpdate(Request $request)
    {
        $id     = Auth::user()->id;
        $update = User::findOrFail($id);

        $update->name    = $request->name;
        $update->email   = $request->email;
        $update->phone   = $request->phone;
        $update->address = $request->address;

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // Delete old image if exists
            if ($update->image) {
                Storage::delete('public/user_images/' . $update->image);
            }

            // Store new image
            $filename      = date('YmdHi') . '_' . $file->getClientOriginalName();
            $path          = $file->storeAs('public/user_images', $filename);
            $update->image = $filename;
        }

        $update->save();

        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }

    //User Password
    public function userPasswordPage()
    {
        $id       = Auth::user()->id;
        $userData = User::find($id);

        return view('user.pages.profile.user_password', compact('userData'));
    }

    //Admin Password Update
    public function userPasswordUpdateSubmit(Request $request)
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
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password Change Succeesfully');
    }
}
