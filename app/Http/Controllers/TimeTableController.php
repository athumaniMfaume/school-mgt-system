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
     * Display the timetable form.
     */
    public function index()
    {
        $day = Day::all();
        $class = Classes::all();
        $subject = Subject::all();
        return view('admin.timetable.timetable', compact('day', 'class', 'subject'));
    }

    /**
     * Read and display the list of timetables.
     */
    public function read(Request $request)
    {
        $query = TimeTable::with(['classes', 'subject', 'day']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $data = $query->get();
        $class = Classes::all();

        return view('admin.timetable.timetable_list', compact('data', 'class'));
    }

    /**
     * Store or update timetable entries.
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

        foreach ($request->timetable as $entry) {
            $day_id = $entry['day_id'];
            $start_time = $entry['start_time'];
            $end_time = $entry['end_time'];
            $room_no = $entry['room_no'];

            if ($start_time && $end_time) {
                TimeTable::updateOrCreate(
                    [
                        'class_id' => $class_id,
                        'subject_id' => $subject_id,
                        'day_id' => $day_id,
                    ],
                    [
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                        'room_no' => $room_no,
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Timetable updated successfully!');
    }

    /**
     * Show the form for editing a specific timetable entry.
     */
public function edit($id)
{
    $data = TimeTable::findOrFail($id); // Fetch the timetable entry by ID
    $day = Day::all();
    $classes = Classes::all();
    $subject = Subject::all();

    return view('admin.timetable.timetable_edit', compact('data', 'day', 'classes', 'subject'));
}


    /**
     * Update a specific timetable entry.
     */
public function update(Request $request)
{
    $request->validate([
        'id' => 'required|exists:time_tables,id',
        'class_id' => 'required|exists:classes,id',
        'subject_id' => 'required|exists:subjects,id',
        'day_id' => 'required|exists:days,id',
        'start_time' => 'required',
        'end_time' => 'required',
        'room_no' => 'required',
    ]);

    // Fetch the timetable record first
    $timeTable = TimeTable::findOrFail($request->id);

    // Check for duplicate entry (except current one)
    $exists = TimeTable::where('class_id', $request->class_id)
        ->where('subject_id', $request->subject_id)
        ->where('day_id', $request->day_id)
        ->where('id', '!=', $timeTable->id)
        ->exists();

    if ($exists) {
        return redirect()->back()->with('error', 'This timetable entry already exists.');
    }

    // Update the timetable
    $timeTable->update([
        'class_id' => $request->class_id,
        'subject_id' => $request->subject_id,
        'day_id' => $request->day_id,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'room_no' => $request->room_no,
    ]);

    return redirect()->route('time_table.read')->with('success', 'Timetable updated successfully!');
}




    /**
     * Delete a timetable entry.
     */
    public function delete($id)
    {
        $data = TimeTable::findOrFail($id);
        $data->delete();
        return redirect()->route('time_table.read')->with('success', 'Timetable deleted successfully!');
    }
}
