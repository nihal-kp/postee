<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        //dd(Post::get());          //this is a laravel collection object with information of all posts. We can retrieve its properties(body,date) in posts.index view page.
        //$posts = Post::get();       //Or Post::all(); 
        //Latest 
        $posts = Post::latest()->with(['user','likes'])->paginate(10);       //with(['user','likes']) means eager loading with user and likes relationships, that were already been created in Post Model. This is the best way to reduce query statements in iteration while executing. We can check this queries execution using debugloader.
        //Or $posts = Post::paginate(10);   //Using pagination to view posts 10 per page. Use {{ $posts->links() }} in posts/index.blade.php page  to show pagination links.
        return view('posts.index',['posts'=>$posts]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        // Post::create([
        //     'user_id' => Auth::id(),                        //Auth::user()->id()
        //     'body' => $request->body,
        // ]);
        //Or
        Auth::user()->posts()->create($request->only('body'));       //Here laravel automatically filling 'user_id' using hasMany relationship setup.
        return back();
    }

    public function destroy(Post $post, Request $request)           //(Post $post) means destroy function takes $post via route model binding
    {
        //dd($post);
        $post->delete();
        return back();
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }
}
