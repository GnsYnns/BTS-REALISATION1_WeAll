<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['user_id', 'post_message_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postMessage()
    {
        return $this->belongsTo(Post_message::class);
    }
}

