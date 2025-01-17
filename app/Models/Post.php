<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'title',
        'post',
        'images',
        'id',
        'datePosted',
        'lastUpdated',
        'author',
        'tags',
        'likes',
        'dislikes'
    ];

    protected $appends = [
        'post_preview',
        'author_details',
        'formatted_date',
        'liked',
        'disliked',
        'comments_amt',
        'post_image'
    ];

    protected function getPostImageAttribute($value): string {
        return asset(Storage::url($value) );
    }
    protected function getPostPreviewAttribute(): string
    {
        $postPreview = substr($this->post, 0, 350);
        return $postPreview;
    }

    protected function getAuthorDetailsAttribute(): User
    {
        $authorID = $this->author;
        $authorDetails = User::find($authorID);
        return $authorDetails;
    }

    protected function getLikedAttribute(): bool
    {
        if (DB::table('postlikesdislikes')->where('postID', '=', $this->id)->exists() == false) {
            return false;
        } else {
            $post = PostLikesDislikes::firstWhere('postID', '=', $this->id);
            if ($post->liked == 1) {
                return true;
            } 
            return false;
        }
    }
    protected function getDislikedAttribute(): bool
    {
        if (DB::table('postlikesdislikes')->where('postID', '=', $this->id)->exists() == false) {
            return false;
        } else {
            $post = PostLikesDislikes::firstWhere('postID', '=', $this->id);
            if ($post->disliked == 1) {
                return true;
            } 
            return false;
        }
    }

    protected function getCommentsAmtAttribute(): int
    {
        return Comment::where('postID', $this->id)->count();

    }
    protected function getFormattedDateAttribute(): string
    {
         
       return Carbon::create($this->datePosted)->toDayDateTimeString();
       
    }
}
