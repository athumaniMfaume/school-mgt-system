<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.announcement.announcement');
    }

    public function read()
    {
        $data = Announcement::latest()->get();
        return view('admin.announcement.announcement_list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit(Request $request, $id)
    {
        $data = Announcement::findOrFail($id);
        return view('admin.announcement.announcement_edit',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'type' => 'required',
        ]);

        $data = new Announcement();
        $data->message = $request->message;
        $data->type = $request->type;
        $data->save();

        return redirect()->back()->with('success', 'Announcement Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Announcement $announcement)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $data = Announcement::findOrFail($request->id);
        $request->validate([
            'message' => 'required',
            'type' => 'required',
        ]);

        $data->message = $request->message;
        $data->type = $request->type;
        $data->update();

        return redirect()->route('announcement.read')->with('success', 'Announcement Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = Announcement::findOrFail($id);
        $data->delete();

        return redirect()->route('announcement.read')->with('success', 'Announcement Deleted Successfully!');
    }
}
