<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExamGrade extends Model
{
    protected $fillable = ['user_id', 'exam_id', 'average_score', 'grade'];

        public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
