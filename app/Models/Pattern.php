<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Carbon;

class Pattern extends Model
{
    
    protected $fillable = [
        'title',
        'description',
        'coverimage',
        'pdf',
        'id',
        'author',
        'datePosted'
    ];

    protected $appends = [
        'cover_image',
        'pdf_link',
        'author_details',
        'formatted_date'
    ];

    protected function getFormattedDateAttribute(): string
    {
       return Carbon::create($this->datePosted)->toDateString();
    }

    protected function getAuthorDetailsAttribute(): User {
        return User::find($this->author);
       
    }
    protected function getCoverImageAttribute($value): string {
        return asset(Storage::url($value) );
    }
    protected function getPdfLinkAttribute($value): string {
        return asset(Storage::url($value) );
    }
}
