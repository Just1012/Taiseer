<?php

namespace App\Models;

use App\Models\User;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Exception;


class Chat extends Model
{
    protected $appends = ['chat_name'];

    protected $guarded = [];
    use HasFactory;
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function getChatNameAttribute()
    {
        // Define the chat name logic here, e.g., based on shipment ID or name
        if ($this->shipment_id == null) {
            try {
                return User::find(Str::replaceFirst('User# ', '',  $this->name))->name;
            } catch (Exception $e) {
                return $this->name;
            }
        } else {
            return $this->name;
        }
    }
}
