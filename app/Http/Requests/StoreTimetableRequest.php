<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTimetableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
public function rules()
{
    return [
        'class_id' => 'required|exists:classes,id',
        'subject_id' => 'required|exists:subjects,id',
        'timetable.*.day_id' => 'required|exists:days,id',
        'timetable.*.start_time' => 'required|date_format:H:i',
        'timetable.*.end_time' => 'required|date_format:H:i|after:timetable.*.start_time',
        'timetable.*.room_no' => 'required',
    ];
}

}
