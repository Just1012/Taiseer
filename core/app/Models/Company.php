<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function typeActivityCompanies()
    {
        return $this->hasMany(TypeActivityCompany::class, 'company_id');
    }
    public function country()
    {
        return $this->hasMany(CompanyCountry::class, 'company_id');
    }
    public function city()
    {
        return $this->hasMany(CompanyCity::class, 'company_id');
    }
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'company_countries', 'company_id', 'country_id');
    }
    public function cities()
    {
        return $this->belongsToMany(City::class, 'company_cities', 'company_id', 'city_id');
    }
    public function followers()
    {
        return $this->hasMany(Follower::class,);
    }
}
