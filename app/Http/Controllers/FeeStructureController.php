<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\FeeHead;
use App\Models\FeeStructure;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        $class = Classes::get();
        $fee = FeeHead::get();
        $academic = AcademicYear::get();

        return view('admin.fee_structure.fee_structure', compact('class', 'fee', 'academic'));
    }

    public function create()
    {
        //
    }

    public function read(Request $request)
    {
        $query = FeeStructure::query()->with('fee_head', 'academic_year', 'classes');

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $data = $query->get();
        $class = Classes::all();
        $fee = FeeHead::all();
        $academic = AcademicYear::all();

        return view('admin.fee_structure.fee_structure_list', compact('data', 'class', 'fee', 'academic'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'fee_head_id' => 'required',
            'academic_year_id' => 'required',
            'april' => 'required',
            'may' => 'required',
            'june' => 'required',
            'july' => 'required',
            'august' => 'required',
            'september' => 'required',
            'october' => 'required',
            'november' => 'required',
            'december' => 'required',
            'january' => 'required',
            'february' => 'required',
            'march' => 'required',
        ]);

        // Check uniqueness
        $exists = FeeStructure::where('class_id', $request->class_id)
            ->where('fee_head_id', $request->fee_head_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Fee Structure already exists for this class, fee head, and academic year.');
        }

        $data = new FeeStructure();
        $data->class_id = $request->class_id;
        $data->fee_head_id = $request->fee_head_id;
        $data->academic_year_id = $request->academic_year_id;
        $data->april = $request->april;
        $data->may = $request->may;
        $data->june = $request->june;
        $data->july = $request->july;
        $data->august = $request->august;
        $data->september = $request->september;
        $data->october = $request->october;
        $data->november = $request->november;
        $data->december = $request->december;
        $data->january = $request->january;
        $data->february = $request->february;
        $data->march = $request->march;

        $data->save();

        return redirect()->route('fee_structure.create')->with('success', 'Fee Structure Added Successfully!');
    }

    public function show(FeeStructure $feeStructure)
    {
        //
    }

    public function edit(Request $request, $id)
    {
        $data = FeeStructure::with('fee_head', 'academic_year', 'classes')->find($id);
        $class = Classes::get();
        $fee = FeeHead::get();
        $academic = AcademicYear::get();
        return view('admin.fee_structure.fee_structure_edit', compact('data', 'class', 'fee', 'academic'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:fee_structures,id',
            'class_id' => 'required',
            'fee_head_id' => 'required',
            'academic_year_id' => 'required',
            'april' => 'required',
            'may' => 'required',
            'june' => 'required',
            'july' => 'required',
            'august' => 'required',
            'september' => 'required',
            'october' => 'required',
            'november' => 'required',
            'december' => 'required',
            'january' => 'required',
            'february' => 'required',
            'march' => 'required',
        ]);

        // Check uniqueness excluding current ID
        $exists = FeeStructure::where('class_id', $request->class_id)
            ->where('fee_head_id', $request->fee_head_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('id', '!=', $request->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Another Fee Structure already exists for this class, fee head, and academic year.');
        }

        $data = FeeStructure::find($request->id);
        $data->class_id = $request->class_id;
        $data->fee_head_id = $request->fee_head_id;
        $data->academic_year_id = $request->academic_year_id;
        $data->april = $request->april;
        $data->may = $request->may;
        $data->june = $request->june;
        $data->july = $request->july;
        $data->august = $request->august;
        $data->september = $request->september;
        $data->october = $request->october;
        $data->november = $request->november;
        $data->december = $request->december;
        $data->january = $request->january;
        $data->february = $request->february;
        $data->march = $request->march;

        $data->update();

        return redirect()->route('fee_structure.read')->with('success', 'Fee Structure Updated Successfully!');
    }

    public function delete($id)
    {
        $data = FeeStructure::findOrFail($id);
        $data->delete();
        return redirect()->route('fee_structure.read')->with('success', 'Fee Structure Deleted Successfully!');
    }
}
