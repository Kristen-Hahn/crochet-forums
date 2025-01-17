<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostLikesDislikes extends Model
{
    public $table = 'postlikesdislikes';   
    protected $fillable = [
        'postID',
        'userID',
        'liked',
        'disliked'
    ];

}
