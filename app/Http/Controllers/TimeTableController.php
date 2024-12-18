<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Day;
use App\Models\Subject;
use App\Models\TimeTable;
use Illuminate\Http\Request;

class TimeTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $day = Day::all();
        $class = Classes::all();
        $subject = Subject::all();
        return view('admin.timetable.timetable',compact('day','class','subject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function read(Request $request)
    {
    $query = TimeTable::query()->with('classes','subject','day');

    // Apply filters based on request
    if ($request->filled('class_id')) {
        $query->where('class_id', $request->class_id);
    }


    $data = $query->get();
    $class = Classes::all();


    return view('admin.timetable.timetable_list', compact('data','class'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'timetable.*.day_id' => 'required|exists:days,id',
            'timetable.*.start_time' => 'required',
            'timetable.*.end_time' => 'required',
            'timetable.*.room_no' => 'required',
        ]);


        $class_id = $request->class_id;
        $subject_id = $request->subject_id;


        foreach ($request->timetable as $timetable) {
            $day_id = $timetable['day_id'];
            $start_time = $timetable['start_time'];
            $end_time = $timetable['end_time'];
            $room_no = $timetable['room_no'];

            if ($start_time != null) {
                TimeTable::updateOrCreate(
                    [
                        'class_id'=>$class_id,
                        'subject_id'=>$subject_id,
                        'day_id'=>$day_id
                    ],
                    [
                        'class_id'=>$class_id,
                        'subject_id'=>$subject_id,
                        'start_time'=>$start_time,
                        'end_time'=>$end_time,
                        'day_id'=>$day_id,
                        'room_no'=>$room_no,
                    ]
                );
            }

        }

        return redirect()->back()->with('success','Time table created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeTable $timeTable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeTable $timeTable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TimeTable $timeTable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $data = TimeTable::findOrFail($id);
        $data->delete();
        return redirect()->route('time_table.read')->with('success', 'TimeTable Deleted Successfully!');
    }
}
