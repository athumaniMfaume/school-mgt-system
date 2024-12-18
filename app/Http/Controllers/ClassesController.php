<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Classes::get();
        return view('admin.class.class');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function read()
    {
        $data = Classes::get();
        return view('admin.class.class_list',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $data = new Classes();
        $data->name = $request->name;
        $data->save();
        return redirect()->route('class.create')->with('success', 'Class Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $data = Classes::find($id);
        return view('admin.class.class_edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required'
        ]);
        $data = Classes::find($request->id);
        $data->name = $request->name;
        $data->update();
        return redirect()->route('class.read')->with('success', 'Class Updated Successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = Classes::find($id);
        $data->delete();
        return redirect()->route('class.read')->with('success', 'Class Deleted Successfully!');

    }
}
