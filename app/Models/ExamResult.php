<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'user_id');

    }

    public function exam(){
        return $this->belongsTo(Exam::class,'exam_id');

    }

    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');

    }
}
