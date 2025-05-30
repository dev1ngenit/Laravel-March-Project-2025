<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReturnPolicy;
use Illuminate\Http\Request;

class ReturnPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'items' => ReturnPolicy::latest('id')->get(),
        ];

        return view('admin.pages.return-policy.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.return-policy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'version'         => 'required|string|max:250',
            'effective_date'  => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:effective_date',
            'status'          => 'required|in:active,inactive',
        ]);

        // Create and save the new Support & Policy record
        ReturnPolicy::create([
            'title'           => $request->title,
            'content'         => $request->content,
            'version'         => $request->version,
            'effective_date'  => $request->effective_date,
            'expiration_date' => $request->expiration_date,
            'status'          => $request->status,
        ]);

        // Redirect with a success message
        return redirect()->route('admin.return-policy.index')->with('success', 'Return & Policy created successfully.');

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
            'item' => ReturnPolicy::findOrFail($id),
        ];
        return view('admin.pages.return-policy.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate request data
        $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'required|string',
            'version'         => 'required|string|max:50',
            'effective_date'  => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:effective_date',
            'status'          => 'required|in:active,inactive',
        ]);

        // Find the existing Support & Policy and update it
        $item = ReturnPolicy::findOrFail($id);

        $item->update([
            'title'           => $request->title,
            'content'         => $request->content,
            'version'         => $request->version,
            'effective_date'  => $request->effective_date,
            'expiration_date' => $request->expiration_date,
            'status'          => $request->status,
        ]);

        // Redirect with success message
        return redirect()->route('admin.return-policy.index')->with('success', 'Return & Policy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = ReturnPolicy::findOrFail($id);
        $item->delete();

    }
}
