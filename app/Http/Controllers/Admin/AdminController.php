<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch admins where admin_role_type is 'site_testing'
        $admins = Admin::whereIn('admin_role_type', ['site_testing'])->latest()->get();


        // Pass all the necessary data to the view
        return view('admin/dashboard', compact('admins'));
    }
}
