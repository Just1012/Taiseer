<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function shipment(){
        return $this->belongsTo(Shipment::class,'shipment_id');
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
}
