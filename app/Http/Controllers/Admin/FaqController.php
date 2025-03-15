<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'faqs' => faq::latest('id')->get(),
        ];

        return view('admin.pages.faq.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'question'        => 'required|string|max:255',
            'answer'          => 'required|string',
            'order'           => 'required|integer|min:0',
            'status'          => 'required|in:active,inactive',
            'additional_info' => 'nullable|string',
        ]);

        // Store the data
        Faq::create([
            'question'        => $request->input('question'),
            'answer'          => $request->input('answer'),
            'order'           => $request->input('order'),
            'status'          => $request->input('status'),
            'additional_info' => $request->input('additional_info'),
        ]);

        // Redirect with success message
        return redirect()->route('admin.faq.index')->with('success', 'FAQ created successfully.');
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
            'faq' => Faq::findOrFail($id),
        ];
        return view('admin.pages.faq.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the input
        $request->validate([
            'question'        => 'required|string|max:255',
            'answer'          => 'required|string',
            'order'           => 'required|integer|min:0',
            'status'          => 'required|in:active,inactive',
            'additional_info' => 'nullable|string',
        ]);

        // Find the FAQ entry
        $faq = Faq::findOrFail($id);

        // Update the FAQ entry
        $faq->update([
            'question'        => $request->input('question'),
            'answer'          => $request->input('answer'),
            'order'           => $request->input('order'),
            'status'          => $request->input('status'),
            'additional_info' => $request->input('additional_info'),
        ]);

        // Redirect with success message
        return redirect()->route('admin.faq.index')->with('success', 'FAQ updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the FAQ by ID
        $faq = Faq::findOrFail($id);
        $faq->delete();
    }
}
