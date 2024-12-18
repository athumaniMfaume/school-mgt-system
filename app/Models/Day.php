<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    public function timetable(){
        return $this->hasMany(TimeTable::class,'day_id');
    }
}
