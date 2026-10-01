<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    
    // A message can belong to both an incoming and an outgoing user
    public function incomingUser()
    {
        return $this->belongsTo(User::class, 'incoming_msg_id');
    }

    public function outgoingUser()
    {
        return $this->belongsTo(User::class, 'outgoing_msg_id');
    }
}
