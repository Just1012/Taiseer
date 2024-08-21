<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCountry extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function countries(){
        return $this->hasMany(Country::class,'country_id');
    }
}
