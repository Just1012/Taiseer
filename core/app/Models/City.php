<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_cities', 'city_id', 'company_id');
    }
}
