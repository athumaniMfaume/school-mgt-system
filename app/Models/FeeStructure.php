<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = [
        'fee_head_id',
        'class_id',
        'academic_year_id',
        'april',
        'may',
        'june',
        'july',
        'august',
        'september',
        'october',
        'november',
        'december',
        'january',
        'february',
        'nmarch',

    ];

    public function classes(){
        return $this->belongsTo(Classes::class,'class_id');
    }

    public function fee_head(){
        return $this->belongsTo(FeeHead::class,'fee_head_id');
    }

    public function academic_year(){
        return $this->belongsTo(AcademicYear::class,'academic_year_id');
    }
}
