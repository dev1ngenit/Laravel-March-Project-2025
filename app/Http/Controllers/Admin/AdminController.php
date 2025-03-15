<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $id     = Auth::guard('admin')->user()->id;
        $admin  = Admin::findOrFail($id);
        $status = $admin->status;

        return view('admin/dashboard', compact('status'));
    }
}
