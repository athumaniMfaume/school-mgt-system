<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignSubjectToClass extends Model
{

    protected $fillable = [
        'class_id',
        'subject_id',
        'status',
    ];
    public function classes(){
        return $this->belongsTo(Classes::class,'class_id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
    }
}
