<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index(){
        return view('admin.academic_year');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required'
        ]);

        $data = new AcademicYear();
        $data->name = $request->name;
        $data->save();
        // dd($request->name);
        return redirect()->route('academic-year.create')->with('success', 'Academic Year Added Successfully!!');
    }

    public function read(){
        $data = AcademicYear::get();
        // dd($data);
        return view('admin.academic_year_list',compact('data'));
    }

    public function delete($id){
        $data = AcademicYear::find($id);
        $data->delete();
        // dd($data);
        return redirect()->route('academic-year.read')->with('success', 'Delete Successfully!!');
    }

    public function edit(Request $request, $id){
        $data = AcademicYear::find($id);
        
        return view('admin.academic_year_edit',compact('data'));
    }

    public function update(Request $request){
        $request->validate([
            'name'=>'required'
        ]);

        $data = AcademicYear::find($request->id);
        $data->name = $request->name;
        $data->update ();
        // dd($request->name);
        return redirect()->route('academic-year.read')->with('success', 'Academic Year Update Successfully!!');
    }
}
