<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeActivityCompany extends Model
{
    use HasFactory;
    protected $guarded = [

    ];


    public function typeActivities(){
        return $this->belongsTo(TypeActivity::class,'type_activity_id');
    }
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
