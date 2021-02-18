<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Post $post, Request $request)
    {
        //dd($post);      //Returns Post Model object with information of 1 post which we have liked.
        //dd($post->likedBy(Auth::user()));       //Here retuns true or false. If user already likes that particular posts then returns true, if user is liking that particular post for first time then returns true. This likedBy function is created in Post Model.
        
        //this if condition is not required here because already we use this likedBy() function and make changes in posts/index.blade.php page
        if ($post->likedBy(Auth::user())) {         //If currently authenticated user already likes that particular posts and once more liking that posts then here returns error page. This likedBy function is created in Post Model.
            return response(null, 409);             //returns 409 error page
        }
        $post->likes()->create([
            'user_id'=>Auth::id(),            //Auth::user()->id()    OR  //$request->user()->id()
        ]);
        return back();
    }

    public function destroy(Post $post, Request $request)
    {
        Auth::user()->likes()->where('post_id',$post->id)->delete();         //Currently authenticated user_id with where (particular post id) in likes table
        //Or    $request->user()->likes()->where('post_id',$post->id)->delete();
        return back();
    }
}
