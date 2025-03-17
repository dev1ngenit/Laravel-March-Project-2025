<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'coupons' => Coupon::latest('id')->get(),
        ];

        return view('admin.pages.coupon.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'status'            => 'required',
            'name'              => 'required|string|max:255',
            'badge'             => 'required|string|max:30',
            'coupon_code'       => 'required|string|max:30',

            'price'             => 'nullable|numeric',
            'offer_price'       => 'nullable|numeric',

            'start_date'        => 'required|date',
            'expiry_date'       => 'required|date',

            'notification_date' => 'nullable|date',

            'locations'         => 'nullable|url',
            'url'               => 'nullable|url',
            'source_url'        => 'nullable|url',
            'map_url'           => 'nullable|url',

            'description'       => 'nullable|string',
        ];

        // Define custom error messages
        $messages = [

            'locations.required'   => 'The Location URL field cannot be empty.',
            'url.required'         => 'The URL field cannot be empty.',
            'source_url.required'  => 'The source URL field cannot be empty.',
            'map_url.required'     => 'The map URL field cannot be empty.',
            'description.required' => 'The description field cannot be empty.',
        ];

        // Validate the incoming data
        $request->validate($rules, $messages);

        // After validation, proceed to store the data
        Coupon::create($request->all());

        // Redirect with success message
        return redirect()->route('admin.coupon.index')->with('success', 'Coupon created successfully!');
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
            'coupon' => Coupon::findOrFail($id),
        ];
        return view('admin.pages.coupon.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Define validation rules
        $rules = [
            'status'            => 'required',
            'name'              => 'required|string|max:255',
            'badge'             => 'required|string|max:30',
            'coupon_code'       => 'required|string|max:30',

            'price'             => 'nullable|numeric',
            'offer_price'       => 'nullable|numeric',

            'start_date'        => 'required|date',
            'expiry_date'       => 'required|date',

            'notification_date' => 'nullable|date',

            'locations'         => 'nullable|url',
            'url'               => 'nullable|url',
            'source_url'        => 'nullable|url',
            'map_url'           => 'nullable|url',

            'description'       => 'nullable|string',
        ];

        // Define custom error messages
        $messages = [
            'locations.required'   => 'The Location URL field cannot be empty.',
            'url.required'         => 'The URL field cannot be empty.',
            'source_url.required'  => 'The source URL field cannot be empty.',
            'map_url.required'     => 'The map URL field cannot be empty.',
            'description.required' => 'The description field cannot be empty.',
        ];

        // Validate the incoming data
        $request->validate($rules, $messages);
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());

        // Redirect with success message
        return redirect()->route('admin.coupon.index')->with('success', 'Coupon updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
    }

}
