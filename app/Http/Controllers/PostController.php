<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\PostLikesDislikes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;



class PostController extends Controller
{

    public function uploadPostImage(Request $request, int $id){
        if($request->hasFile('postimage')){
    $link = Storage::disk('public')->put('photos', $request->file('postimage'));
    Post::find($id)->update(['images' => $link]);
}
}
    public function store(Request $request)
    {
        //   dd(vars: $request->file);
        $validated = $request->validate([
            'title' => 'required',
            'post' => 'required',
        ]);
        $post = Post::create([
            'title' => $validated['title'],
            'post' => $validated['post'],
            'author' => $request->user()->id,
            'datePosted' => Carbon::now()->setTimezone('EST'),
            'likes' => 0,
            'dislikes' => 0
        ]);
        
        PostController::uploadPostImage($request, $post->id);


    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required',
            'post' => 'required',
            'postID' => 'required'
        ]);
        $post = Post::find($validated['postID']);
        $post->update([
            'title' => $validated['title'],
            'post' => $validated['post'],
            'lastUpdated' => now()
        ]);

        PostController::uploadPostImage($request, $validated['postID']);

    }

    public function delete(Request $request)
    {
        $post = Post::find($request->postid);
        $postComments = Comment::where('postID', '=', $request->postid);
        $post->delete();
        $postComments->delete();
        return redirect(to: route('home'));

    }

    public function removeDislike(Request $request)
    {
        $post = Post::find($request->postID);
        $updatePostLikesDislikes = PostLikesDislikes::where('postID', '=', $request->postID);
        $updatePostLikesDislikes->update([
            'disliked' => false,
        ]);
        $post->update([
            'dislikes' => $post->dislikes - 1
        ]);
    }
    public function removeLike(Request $request)
    {
        $post = Post::find($request->postID);
        $updatePostLikesDislikes = PostLikesDislikes::where('postID', '=', $request->postID);
        $updatePostLikesDislikes->update([
            'liked' => false,
        ]);
        $post->update([
            'likes' => $post->likes - 1
        ]);
    }
    public function addLike(Request $request)
    {
        $post = Post::find($request->postID);
        $likes = $post->likes;
        $dislikes = $post->dislikes;

        if ($request->removedislike == true) {
            $dislikes = $dislikes - 1;
        }

        if (DB::table('postlikesdislikes')->where('postID', '=', $request->postID)->exists() == false) {
            $postliked = PostLikesDislikes::create([
                'postID' => $request->postID,
                'userID' => $request->user()->id,
                'disliked' => false,
                'liked' => true
            ]);
        } else {
            $updatePostLikesDislikes = PostLikesDislikes::where('postID', '=', $request->postID);
            $updatePostLikesDislikes->update([
                'disliked' => false,
                'liked' => true,
            ]);
        }
        $post->update([
            'likes' => $likes + 1,
            'dislikes' => $dislikes
        ]);
    }
    public function addDislike(Request $request)
    {
        $post = Post::find($request->postID);
       
        if (DB::table('postlikesdislikes')->where('postID', '=', $request->postID)->exists() == false) {
            $postliked = PostLikesDislikes::create([
                'postID' => $request->postID,
                'userID' => $request->user()->id,
                'disliked' => true,
                'liked' => false
            ]);
        } else {
            $updatePostLikesDislikes = PostLikesDislikes::where('postID', '=', $request->postID);
            $updatePostLikesDislikes->update([
                'disliked' => true,
                'liked' => false,
            ]);
        }
        $post->increment('dislikes');
        if($request->removelike == true){
        $post->decrement('likes');
        }
    }

    public function adjustLikes(Request $request)
    {
        if ($request->liked == true) {
            PostController::addLike($request);
        } else if ($request->disliked == true) {
            PostController::addDislike($request);
        } else if ($request->removelike == true) {
            PostController::removeLike($request);
        } else if ($request->removedislike == true) {
            PostController::removeDislike($request);
        }
    }

}