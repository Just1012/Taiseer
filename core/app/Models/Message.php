<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    // Relationship with sender (User)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
