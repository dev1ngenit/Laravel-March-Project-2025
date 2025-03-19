<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $id     = Auth::guard('admin')->user()->id;
        $admin  = Admin::findOrFail($id);
        $status = $admin->status;

        $userCount  = User::where('status', 'active')->count();
        $adminCount = Admin::where('status', 'active')->count();

        return view('admin/dashboard', compact('status', 'userCount', 'adminCount'));
    }
}
