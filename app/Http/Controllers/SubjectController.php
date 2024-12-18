<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.subject.subject');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function read(Request $request)
    {
    $query = Subject::query();

    // Apply filters based on request
    if ($request->filled('name')) {
        $query->where('name', $request->name);
    }


    $data = $query->get();
    $subject = Subject::all();


    return view('admin.subject.subject_list', compact('data', 'subject'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $data = new Subject();
        $data->name = $request->name;
        $data->type = $request->type;
        $data->save();

        return redirect()->back()->with('success', 'Subject Added Successfully');


    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {

        $data = Subject::find($id);
        return view('admin.subject.subject_edit', compact('data'));



    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $data = Subject::find($request->id);

        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);

        $data->name = $request->name;
        $data->type = $request->type;

        $data->save();
        return redirect()->route('subject.read')->with('success', 'Subject updated successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = Subject::find($id);
        $data->delete();
        return redirect()->route('subject.read')->with('success', 'Subject deleted successfully!');
    }
}
