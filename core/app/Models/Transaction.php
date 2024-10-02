<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function shipment(){
        return $this->belongsTo(Shipment::class,'shipment_id');
    }
    public function changedBy(){
        return $this->belongsTo(User::class,'changed_by');
    }
}
