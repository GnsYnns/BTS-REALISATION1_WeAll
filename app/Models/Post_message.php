<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_message extends Model
{
    use HasFactory;

    protected $table = 'post_message';

    protected $fillable = [
        'id_users',
        'text',
        'nb_comment',
        'nb_like',
        'created_at',
        'id_referencecomment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
