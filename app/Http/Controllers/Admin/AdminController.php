<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // admin dashboard
    public function dashboard()
    {
        $data = [
            'status' => Auth::guard('admin')->user()->status,
            'userCount' => User::where('status', 'active')->count(),
            'productCount' => Product::where('status', 'active')->count(),
            'alladmins' => Admin::where('status', 'active')->latest('id')->get(),
        ];

        return view('admin.dashboard', $data);
    }

    // markAsRead notification
    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);

        if ($notification && $notification->notifiable_id == Auth::guard('admin')->id()) {
            $notification->markAsRead();
        }

        return redirect($notification->data['url'] ?? route('admin.dashboard'));
    }

}
