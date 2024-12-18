<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeHead extends Model
{

    protected $fillable = [
        'name'
    ];

    public function fee_structure(){
        return $this->hasMany(FeeStructure::class,'fee_head_id');
    }
}
