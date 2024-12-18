<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
        'name'
    ];

    public function fee_structure(){
        return $this->hasMany(FeeStructure::class,'academic_year_id');
    }

    public function user(){
        return $this->hasMany(User::class,'academic_year_id');
    }
}

