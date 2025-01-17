<?php

namespace App\Http\Controllers;

use App\Models\CommentLikesDislikes;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use App\Http\Requests\PostCommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Collection;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required',
            'postID' => 'required',
            'replyID' => 'nullable',
        ]);
        $comment = Comment::create([
            'comment' => $validated['comment'],
            'postID' => $validated['postID'],
            'author' => $request->user()->id,
            'replyID' => $validated['replyID'],
            'datePosted' => now(),
            'likes' => 0,
            'dislikes' => 0
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'comment' => 'required',
            'commentID' => 'required'
        ]);
        $comment = Comment::find($validated['commentID']);
        $comment->update([
            'comment' => $validated['comment'],
            'edited' => true,
        ]);
    }
    
    public function delete(Request $request)
    {
        $comment = Comment::find($request->commentid);
        $comment->delete();

    }


    public function removeDislike(Request $request)
    {
        $comment = Comment::find($request->commentID);
        $updateCommentLikesDislikes = CommentLikesDislikes::where('commentID', '=', $request->commentID);
        $updateCommentLikesDislikes->update([
            'disliked' => false,
        ]);
        $comment->update([
            'dislikes' => $comment->dislikes - 1
        ]);
    }
    public function removeLike(Request $request)
    {
        $comment = Comment::find($request->commentID);
        $updateCommentLikesDislikes = CommentLikesDislikes::where('commentID', '=', $request->commentID);
        $updateCommentLikesDislikes->update([
            'liked' => false,
        ]);
        $comment->update([
            'likes' => $comment->likes - 1
        ]);
    }
    public function addLike(Request $request)
    {
        $comment = Comment::find($request->commentID);
        $likes = $comment->likes;
        $dislikes = $comment->dislikes;

        if ($request->removedislike == true) {
            $dislikes = $dislikes - 1;
        }

        if (DB::table('commentlikesdislikes')->where('commentID', '=', $request->commentID)->exists() == false) {
            $commentliked = CommentLikesDislikes::create([
                'commentID' => $request->commentID,
                'postID' => $request->postID,
                'userID' => $request->user()->id,
                'disliked' => false,
                'liked' => true
            ]);
        } else {
            $updateCommentLikesDislikes = CommentLikesDislikes::where('commentID', '=', $request->commentID);
            $updateCommentLikesDislikes->update([
                'disliked' => false,
                'liked' => true,
            ]);
        }
        $comment->update([
            'likes' => $likes + 1,
            'dislikes' => $dislikes
        ]);
    }
    public function addDislike(Request $request)
    {
        $comment = Comment::find($request->commentID);
        $likes = $comment->likes;
        $dislikes = $comment->dislikes;

        if ($request->removelike == true) {
            $likes = $likes - 1;
        }

        if (DB::table('commentlikesdislikes')->where('commentID', '=', $request->commentID)->exists() == false) {
            $commentliked = CommentLikesDislikes::create([
                'commentID' => $request->commentID,
                'userID' => $request->user()->id,
                'disliked' => true,
                'liked' => false
            ]);
        } else {
            $updateCommentLikesDislikes = CommentLikesDislikes::where('commentID', '=', $request->commentID);
            $updateCommentLikesDislikes->update([
                'disliked' => true,
                'liked' => false,
            ]);
        }
        $comment->update([
            'likes' => $likes,
            'dislikes' => $dislikes + 1
        ]);
    }

    public function adjustLikes(Request $request)
    {
        if ($request->liked == true) {
            CommentController::addLike($request);
        } else if ($request->disliked == true) {
            CommentController::addDislike($request);
        } else if ($request->removelike == true) {
            CommentController::removeLike($request);
        } else if ($request->removedislike == true) {
            CommentController::removeDislike($request);
        }
    }



 }

