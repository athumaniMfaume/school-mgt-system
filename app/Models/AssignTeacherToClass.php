<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignTeacherToClass extends Model
{
    protected $fillable = [
        'class_id',
        'subject_id',
        'user_id',
    ];

    public function classes(){
        return $this->belongsTo(Classes::class,'class_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
