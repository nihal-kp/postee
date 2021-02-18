@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            
            <form action="{{ route('posts') }}" method="post" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label for="body" class="sr-only">Body</label>
                    <textarea name="body" id="body" cols="30" rows="4" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body') border-red-500 @enderror" placeholder="Post something!"></textarea>

                    @error('body')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Post</button>
                </div>
            </form>

            @if ($posts->count())
            @foreach ($posts as $post)
                <div class="mb-4">
                    <a href="{{ route('users.posts',$post->user) }}" class="font-bold">{{ $post->user->name }}</a>          {{-- To print or access 'User' model's correspondng 'name' property ('users' table's 'name' column) in 'Post' model iteration, first make belongsTo relationship in 'Post' model(ie., 'Post' belongsTo 'User')  --}}
                    <span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>       {{-- diffForHumans() is a method to show '5 minutes ago, 1 hours ago, 2 years ago etc.. like that' --}}
                    <p class="mb-2">{{ $post->body }}</p>
                    @if ($post->ownedBy(Auth::user()))                  {{-- This ownedBy() function is created in Post model. If particular post is owned by currently authenticated user then only returns this 'Delete Post' button. Otherwise not shows this 'Delete Post' button--}}
                        <div>
                            <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-500">Delete Post</button>
                            </form>
                        </div>
                    @endif

                    <div class="flex items-center">
                        @auth
                            @if(!$post->likedBy(Auth::user()))          {{-- This likedBy() function is created in Post model to check current authenticated user_id is already in the likes table or not  --}}
                                <form action="{{ route('posts.likes',$post->id) }}" method="POST" class="mr-1">
                                    @csrf
                                    <button type="submit" class="text-blue-500">Like</button>
                                </form>
                            @else
                                <form action="{{ route('posts.likes',$post->id) }}" method="POST" class="mr-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-blue-500">Unlike</button>
                                </form>
                            @endif
                        @endauth

                        <span>{{ $post->likes->count() }} {{ Str::plural('like',$post->likes->count()) }}</span>                {{-- '$post->likes->count()' means prints row count of corresponding 'post_id'.     Str::plural()is using to pluralise. ie., like or likes. For eg: 1 like, 2 likes, 1000 likes --}}
                    </div>
                </div>
            @endforeach

            {{ $posts->links() }}
            @else
                <p>There are no posts</p>
            @endif
        </div>
    </div>

@endsection