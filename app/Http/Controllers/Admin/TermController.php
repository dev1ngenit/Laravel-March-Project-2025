<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'terms' => Term::latest('id')->get(),
        ];

        return view('admin.pages.term.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.term.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'nullable|string',
            'version'         => 'required|string|max:250',
            'effective_date'  => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:effective_date',
            'status'          => 'required|in:active,inactive',
        ]);

        // Create and save the new Term record
        Term::create([
            'title'           => $request->title,
            'content'         => $request->content,
            'version'         => $request->version,
            'effective_date'  => $request->effective_date,
            'expiration_date' => $request->expiration_date,
            'status'          => $request->status,
        ]);

        // Redirect with a success message
        return redirect()->route('admin.term.index')->with('success', 'Term & Condition created successfully.');

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
            'term' => Term::findOrFail($id),
        ];
        return view('admin.pages.term.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate request data
        $request->validate([
            'title'           => 'required|string|max:255',
            'content'         => 'nullable|string',
            'version'         => 'required|string|max:50',
            'effective_date'  => 'nullable|date',
            'expiration_date' => 'nullable|date|after_or_equal:effective_date',
            'status'          => 'required|in:active,inactive',
        ]);

        // Find the existing term and update it
        $term = Term::findOrFail($id);
        $term->update([
            'title'           => $request->title,
            'content'         => $request->content,
            'version'         => $request->version,
            'effective_date'  => $request->effective_date,
            'expiration_date' => $request->expiration_date,
            'status'          => $request->status,
        ]);

        // Redirect with success message
        return redirect()->route('admin.term.index')->with('success', 'Term & Condition updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $term = Term::findOrFail($id);
        $term->delete();

    }
}
