<?php

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get("/posts",function(){
$posts=Post::orderBy('id','DESC')
->paginate(10);س
return $posts;
});

Route::post("/posts",function(){
$post=Post::create(
    [
        'excerpt'=>request('excerpt'),
        'title'=>request('title'),
        'body'=>request('body'),
        'slug'=>request('slug'),
        'user_id'=>1,
        'published_at'=>Carbon::now(),
    ]
);
return $post;
});

Route::put("/posts/{id}",function(){
    $post=Post::findOrFail(request('id'));
$post->update(
    [
        'excerpt'=>request('excerpt'),
        'title'=>request('title'),
        'body'=>request('body'),
        'slug'=>request('slug'),
        'user_id'=>1,
        'published_at'=>Carbon::now(),
    ]
);
return $post;
});

Route::delete("/posts/{id}",function(){
 $post=Post::findOrFail(request('id'));
 $post->delete();
 return $post;
});

