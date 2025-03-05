<?php

use App\Http\Controllers\PatternController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\Pattern;
use App\Models\Comment;


use App\Http\Controllers\CommentController;


Route::get('/', function () {
    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'allPosts' => Post::orderBy('datePosted', 'desc')->get(),

    ]);
})->name('homePage');

Route::get('/home', function () {
    return Inertia::render('Index', [
        'allPosts' => Post::orderBy('datePosted', 'desc')->get(),

    ]);
})->name('home');

Route::get('/patterns', function(){ //'/patterns' name of the link that appears in the url
return Inertia::render('Patterns/PatternHome',[ //renders the vue page in the patterns folder called patternhome.vue
    'patterns' => Pattern::all() //the prop that is being passed to the webpage that is defined in the define props
]);
})->name('Patterns');//the name that you use in the <Link :href="route('Patterns')"> </Link> 
//having a name is not necesary you could just use /patterns in the <Link>

Route::get('/profile', function () {
    return Inertia::render('User/Profile', [
    'posts' =>Post::where('author','=', Auth::user()->id)->get(),
    'user' => Auth::user(),       
    'comments' => Comment::where('author','=', value: Auth::user()->id)->orderBy('datePosted', 'desc')->get(),
    'patterns' => Pattern::where('author','=', value: Auth::user()->id)->orderBy('datePosted', 'desc')->get(),
    ]);
})->middleware(['auth', 'verified'])->name('profile');


Route::get('/viewPost', function (Request $request) {
    $post = Post::find($request->post);

    return Inertia::render(
        'Posts/FullPost',
        [
            'post' => $post,
           'comments' => Comment::where('postID', '=', $request->post)
            ->where('replyID', '=', 0)
            ->orderBy('datePosted', 'desc')->get()
        ]
    );
})->name('viewPost');
Route::get('/viewPattern', function (Request $request) {
    $pattern = Pattern::find($request->pattern);

    return Inertia::render(
        'Patterns/Pattern',
        [
            'pattern' => $pattern,
    
        ]
    );
})->name('viewPattern');


Route::post('/api/uploadPFP', action: [ProfileController::class, 'uploadPFP'])->middleware(['auth','verified']);

Route::post( '/api/uploadCoverImage', action: [PatternController::class, 'store'])->middleware(['auth','verified']);

Route::post( '/uploadpattern', action: [PatternController::class, 'store'])->middleware(['auth','verified'])->name('uploadpattern');

Route::post('/api/updatePost', [PostController::class, 'update'])->middleware(['auth', 'verified']);

Route::post('/editProfile',  [ProfileController::class, 'update'])->middleware(['auth','verified'])->name('editProfile');
Route::post('/editcomment', [CommentController::class, 'update'])->middleware(['auth','verified'])->name('editcomment');
 Route::post('/adjustLikes', [PostController::class, 'adjustLikes'])->name('adjustLikes');
Route::post('/adjustCommentLikes', [CommentController::class, 'adjustLikes'])->name('adjustCommentLikes');
Route::post('/CreatePattern', [PatternController::class, 'store'])->middleware(['auth', 'verified'])->name('createpattern');

Route::post('//api/CreatePost', [PostController::class, 'store'])->middleware(['auth', 'verified']);
Route::post('/PostComment', [CommentController::class, 'store'])->middleware(['auth', 'verified'])->name('postcomment');
Route::delete( '/deletePost', [PostController::class, 'delete'])->middleware(['auth', 'verified'])->name('deletePost');
Route::delete('/deleteComment', [CommentController::class, 'delete'])->middleware(['auth', 'verified'])->name('deleteComment');





require __DIR__ . '/auth.php';
