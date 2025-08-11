<?php

namespace App\Http\Controllers\User\Api;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserDeliveryAddress;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{


    public function register(Request $request)
    {
        $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'phone'         => 'nullable|string|regex:/^\+?[0-9]{10,15}$/|unique:users,phone',
            'customer_type' => 'required|in:customer,partner',
            'password'      => 'required|string|min:8|',
        ], [
            'first_name.required'    => 'First name is required',
            'last_name.required'     => 'Last name is required',
            'email.required'         => 'Email is required',
            'email.email'            => 'Please enter a valid email address',
            'email.unique'           => 'Email already exists',
            'phone.required'         => 'Phone number is required',
            'phone.regex'            => 'Phone number must be valid (10–15 digits, with optional +)',
            'phone.unique'           => 'Phone number already exists',
            'password.required'      => 'Password is required',
            'customer_type.required' => 'Customer Type is required',
            'customer_type.in'       => 'Customer Type must be either customer or partner',
        ]);

        try {
            $user = User::create([
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'email'         => $request->email,
                'phone'         => $request->phone,
                'customer_type' => $request->customer_type,
                'password'      => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Registration Success',
                'status'  => 'success',
                'token'   => $token
            ], 201);
        } catch (\Exception $e) {
            Log::error('User Registration Failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Registration failed. Please try again later.',
                'status'  => 'error'
            ], 500);
        }
    }


    // public function login(Request $request)
    // {
    //     // Validate incoming request
    //     $validator = Validator::make($request->all(), [
    //         'email'    => 'required|email',
    //         'password' => 'required|string|min:8',
    //     ], [
    //         'email.required'    => 'Email is required',
    //         'email.email'       => 'Enter a valid email address',
    //         'password.required' => 'Password is required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Validation error',
    //             'errors'  => $validator->errors(),
    //         ], 422);
    //     }

    //     // Check user existence
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user || !Hash::check($request->password, $user->password)) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Invalid credentials',
    //         ], 401);
    //     }

    //     // Create token using Sanctum
    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Login successful',
    //         'data' => [
    //             'user'  => [
    //                 'id'            => $user->id,
    //                 'first_name'    => $user->first_name,
    //                 'last_name'     => $user->last_name,
    //                 'email'         => $user->email,
    //                 'phone'         => $user->phone,
    //                 'customer_type' => $user->customer_type,
    //             ],
    //             'token' => $token,
    //         ]
    //     ], 200);
    // }

    // public function logout(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();

    //     return response()->json([
    //         'message' => 'Logged out successfully',
    //         'status' => 'success'
    //     ], 200);
    // }


    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email'    => 'required|email',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Validation error',
    //             'errors'  => $validator->errors(),
    //         ], 422);
    //     }

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'status'  => 'error',
    //             'message' => 'Invalid credentials',
    //         ], 401);
    //     }

    //     $request->session()->regenerate();

    //     $user = Auth::user();

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Login successful',
    //         'data' => [
    //             'id'            => $user->id,
    //             'first_name'    => $user->first_name,
    //             'last_name'     => $user->last_name,
    //             'email'         => $user->email,
    //             'phone'         => $user->phone,
    //             'customer_type' => $user->customer_type,
    //         ]
    //     ]);
    // }

    public function login(Request $request)
    {
        // Inside your login controller, temporarily add this
        dd([
            'host' => $request->getHost(),
            'session_domain' => config('session.domain'),
        ]);

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = Auth::user();
        $token = session()->getId();

        // Get dynamically-set session domain
        $cookie = cookie(
            'auth_token',
            $token,
            60 * 24,
            '/',
            config('session.domain'),
            true,
            false,
            false,
            'None'
        );

        return response()->json([
            'status'  => 'success',
            'message' => 'Login successful',
            'data'    => [
                'id'            => $user->id,
                'email'         => $user->email,
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'customer_type' => $user->customer_type,
            ],
        ])->cookie($cookie);
    }
    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return response()->json([
    //         'message' => 'Logged out successfully',
    //         'status'  => 'success'
    //     ]);
    // }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $cookie = Cookie::forget('auth_token', '/', null);

        return response()->json([
            'message' => 'Logged out successfully',
            'status'  => 'success'
        ])->cookie($cookie);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return response()->json([
                'message' => 'Current password is incorrect',
                'status' => 'error'
            ], 400);
        }

        $request->user()->update(['password' => Hash::make($request->new_password)]);

        return response()->json([
            'message' => 'Password changed successfully',
            'status' => 'success'
        ], 200);
    }

    public function reset(Request $request, $token)
    {
        // Delete Token older than 2 minute
        $formatted = now()->subMinutes(2)->toDateTimeString();
        DB::table('password_reset_tokens')->where('created_at', '<=', $formatted)->delete();

        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $passwordreset = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$passwordreset) {
            return response([
                'message' => 'Token is Invalid or Expired',
                'status' => 'failed'
            ], 404);
        }

        // Update the user's password
        User::where('email', $passwordreset->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete the token after resetting password
        DB::table('password_reset_tokens')->where('email', $passwordreset->email)->delete();

        return response([
            'message' => 'Password Reset Success',
            'status' => 'success'
        ], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;

        // Check if the email exists
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response([
                'message' => 'Email does not exist',
                'status' => 'failed'
            ], 404);
        }

        // Generate Token
        $token = Str::random(60);

        // Saving Data to Password Reset Table
        DB::table('password_reset_tokens')->upsert([
            'email' => $email,
            'token' => $token,
            'created_at' => now()
        ], ['email'], ['token', 'created_at']);

        // Sending EMail with Password Reset Token
        Mail::raw("Your password reset token is: $token", function ($message) use ($email) {
            $message->subject('Reset Your Password');
            $message->to($email);
        });

        return response([
            'message' => 'Password Reset Email Sent... Check Your Email',
            'status' => 'success'
        ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
            'message' => 'User profile retrieved successfully.',
            'status' => 'success'
        ], 200);
    }

    public function editProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user()->id,
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
        ]);

        $user = $request->user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'Profile updated successfully',
            'status' => 'success'
        ], 200);
    }


    public function orderList(Request $request)
    {
        // Assuming you have an Order model and a relationship set up
        $user_id = $request->user_id;
        if (!$user_id) {
            return response()->json([
                'message' => 'User ID is required',
                'status' => 'error'
            ], 400);
        }
        $orders = Order::with(['orderItems', 'shippingMethod'])
            ->where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'orders' => $orders,
            'message' => 'Order list retrieved successfully',
            'status' => 'success'
        ], 200);
    }

    public function storeDeliveryAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_email'     => 'required',
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'address_line1'  => 'required|string|max:255',
            'address_line2'  => 'nullable|string|max:255',
            'city'           => 'required|string|max:255',
            'state'          => 'nullable|string|max:255',
            'postal_code'    => 'required|string|max:20',
            'country'        => 'required|string|max:255',
            // 'phone'          => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'phone'          => 'required|string',
            'company'        => 'nullable|string|max:255',
            'is_default'     => 'nullable|boolean',
        ], [
            'user_id.required'       => 'User ID is required',
            'user_id.exists'         => 'User ID must exist in the users table',
            'first_name.required'    => 'First name is required',
            'last_name.required'     => 'Last name is required',
            'address_line1.required' => 'Address line 1 is required',
            'city.required'          => 'City is required',
            'state.required'         => 'State is required',
            'postal_code.required'   => 'Postal code is required',
            'country.required'       => 'Country is required',
            'phone.required'         => 'Phone number is required',
            'phone.regex'            => 'Phone number must be valid (10–15 digits, with optional +)',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // If using Auth, get the user ID from token/session
        $userId = User::where('email' , $request->input('user_email'))->value('id'); // Assumes Sanctum or Passport auth

        $address = UserDeliveryAddress::create([
            'user_id'       => $userId,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city'          => $request->city,
            'state'         => $request->state,
            'postal_code'   => $request->postal_code,
            'country'       => $request->country,
            'phone'         => $request->phone,
            'company'       => $request->company,
            'is_default'    => $request->boolean('is_default', false),
        ]);
        $address->email = $request->input('user_email'); // Add email to the address object
        return response()->json([
            'status'  => 'success',
            'message' => 'Delivery address saved successfully',
            'data'    => $address
        ], 201);
    }
    public function getDeliveryAddresses(Request $request)
    {
        $user_id = $request->user_id;
        if (!$user_id) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $addresses = UserDeliveryAddress::where('user_id', $user_id)->get();

        return response()->json([
            'status'  => 'success',
            'message' => 'Delivery addresses retrieved successfully',
            'data'    => $addresses
        ], 200);
    }
}
