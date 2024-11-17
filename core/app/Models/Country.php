<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public function currency(){
        return $this->belongsTo(Currency::class,'currency_id');
    }
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_countries', 'country_id', 'company_id');
    }

    public function city(){
        return $this->hasMany(City::class);
    }
}
