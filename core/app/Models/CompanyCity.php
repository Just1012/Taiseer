<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCity extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function city(){
        return $this->hasMany(City::class,'city_id');
    }
}
