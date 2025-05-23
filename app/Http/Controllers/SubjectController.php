<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    /**
     * Show the subject management landing page.
     */
    public function index()
    {
        return view('admin.subject.subject');
    }

    /**
     * Display a grouped list of subjects.
     */
    public function read(Request $request)
    {
        $query = Subject::query();

        if ($request->filled('name')) {
            $query->where('name', $request->name);
        }

        // Fetch and group by name so each subject appears once
        $subjects = $query->get()
                          ->groupBy('name');

        return view('admin.subject.subject_list', compact('subjects'));
    }

    /**
     * Store a new subject (name + type).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => [
                'required',
                'string',
                Rule::unique('subjects')->where(function($q) use ($request) {
                    return $q->where('name', $request->name);
                })
            ],
        ], [
            'type.unique' => 'This subject and type combination already exists.',
        ]);

        Subject::create([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->back()->with('success', 'Subject added successfully.');
    }

    /**
     * Show the form for editing a subject entry.
     */
    public function edit($id)
    {
        $data = Subject::findOrFail($id);
        return view('admin.subject.subject_edit', compact('data'));
    }

    /**
     * Update a subject entry.
     */
    public function update(Request $request)
    {
        $subject = Subject::findOrFail($request->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => [
                'required',
                'string',
                Rule::unique('subjects')->where(function($q) use ($request) {
                    return $q->where('name', $request->name);
                })->ignore($subject->id),
            ],
        ], [
            'type.unique' => 'This subject and type combination already exists.',
        ]);

        $subject->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->route('subject.read')->with('success', 'Subject updated successfully.');
    }

    /**
     * Delete a subject entry.
     */
    public function delete($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subject.read')->with('success', 'Subject deleted successfully.');
    }
}
