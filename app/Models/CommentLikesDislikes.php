<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLikesDislikes extends Model
{
    public $table = 'commentlikesdislikes';   
    protected $fillable = [
        'commentID',
        'userID',
        'liked',
        'disliked'
    ];
}
