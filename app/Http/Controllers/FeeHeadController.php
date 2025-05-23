<?php

namespace App\Http\Controllers;

use App\Models\FeeHead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeeHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.fee.fee');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit(Request $request, $id)
    {
        $data = FeeHead::find($id);
        return view('admin.fee.fee_edit', compact('data'));
    }

    public function read()
    {
        $data = FeeHead::get();
        return view('admin.fee.fee_list', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fee_heads,name',
        ]);

        $data = new FeeHead();
        $data->name = $request->name;
        $data->save();

        return redirect()->route('fee.create')->with('success', 'Fee Added Successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:fee_heads,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fee_heads', 'name')->ignore($request->id),
            ],
        ]);

        $data = FeeHead::find($request->id);
        $data->name = $request->name;
        $data->update();

        return redirect()->route('fee.read')->with('success', 'Fee Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = FeeHead::find($id);
        $data->delete();
        return redirect()->route('fee.read')->with('success', 'Fee Deleted Successfully!');
    }
}
