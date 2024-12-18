<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'name'
    ];

    public function fee_structure(){
        return $this->hasMany(FeeStructure::class,'class_id');
    }

    public function user(){
        return $this->hasMany(User::class,'class_id');
    }

    public function assign_subject_class(){
        return $this->hasMany(AssignSubjectToClass::class,'class_id');
    }

    public function assign_teacher_class(){
        return $this->hasMany(AssignTeacherToClass::class,'class_id');
    }

    public function timetable(){
        return $this->hasMany(TimeTable::class,'class_id');
    }

    public function exam(){
        return $this->hasMany(Exam::class,'class_id');
    }
}
