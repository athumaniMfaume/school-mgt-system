<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'type',
        'status',
    ];

    public function assign_subject_class(){
        return $this->hasMany(AssignSubjectToClass::class,'subject_id');
    }

    public function exam_result(){
        return $this->hasMany(ExamResult::class,'subject_id');
    }

    public function assign_teacher_class(){
        return $this->hasMany(AssignTeacherToClass::class,'subject_id');
    }

    public function timetable(){
        return $this->hasMany(TimeTable::class,'subject_id');
    }
}
