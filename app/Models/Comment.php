<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;



class Comment extends Model
{
    protected $fillable = [
        'comment',
        'id',
        'datePosted',
        'edited',
        'author',
        'replyID',
        'postID',
        'likes',
        'dislikes'
    ];

    protected $appends = [
        'author_details',
        'replies',
        'date_formatted',
        'liked',
        'disliked'

    ];
  
    protected function getAuthorDetailsAttribute(): User {
        $authorID = $this->author;
        $authorDetails = User::find($authorID);
        return $authorDetails;
    }
    
    protected function getRepliesAttribute(): Collection {
        return Comment::where('replyID', $this->id)->get();
    }

    protected function getDateFormattedAttribute(): string{
        return Carbon::create($this->datePosted)->toDateString();
    }

    protected function getLikedAttribute(): bool
    {
        if (DB::table('commentlikesdislikes')->where('commentID', '=', $this->id)->exists() == false) {
            return false;
        } else {
            $comment = CommentLikesDislikes::firstWhere('commentID', '=', $this->id);
            if ($comment->liked == 1) {
                return true;
            } 
            return false;
        }
    }

    protected function getDislikedAttribute(): bool
    {
        if (DB::table('commentlikesdislikes')->where('commentID', '=', $this->id)->exists() == false) {
            return false;
        } else {
            $comment = CommentLikesDislikes::firstWhere('commentID', '=', $this->id);
            if ($comment->disliked == 1) {
                return true;
            } 
            return false;
        }
    }


}
