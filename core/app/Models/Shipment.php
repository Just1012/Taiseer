<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    public function addressTo(){
        return $this->belongsTo(Address::class,'to_address_id');
    }
    public function addressFrom(){
        return $this->belongsTo(Address::class,'from_address_id');
    }
}
