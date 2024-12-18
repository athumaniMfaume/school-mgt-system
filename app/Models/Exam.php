<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function classes(){
        return $this->belongsTo(Classes::class,'class_id');

    }

    public function exam_result(){
        return $this->hasMany(ExamResult::class,'exam_id');
    }
}
