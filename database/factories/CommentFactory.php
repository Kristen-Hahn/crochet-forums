<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    public function isReply(int $postID): int{
        $rand = rand(0,100);
        if($rand % 2 == 0){
            return 0;
        }else{
            if(Comment::where('postID', $postID)->count() > 0)
        return Comment::where('postID', $postID)->get()->random()->id;
        }
        return 0;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    

    public function definition(): array
    {
        $postID = Post::all()->random()->id;
        return [
            'comment' => fake()->text(),
            'postID' => $postID,
            'replyID' => $this->isReply($postID),
            'likes' => rand(0,200),
            'dislikes' =>rand(0,200) ,
            'author' => User::all()->random()->id,
            'datePosted' =>fake()->date(),
        ];
    }
}
