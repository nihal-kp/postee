<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likedBy(User $user)
    {
        return $this->likes->contains('user_id', $user->id);       //If the user_id is already in the list of likes of the particular Post Model. If user_id already exists then return true otherwise false. We can dd() this likedBy() in PostLikeController this to check true or false  //contains() is a laravel collection method(like get(), all(), first()..) to check that particular key contains in that likes table (or likes collection object). This ownedBy() function is called in posts/index.blade.php file and in PostLikeController.php file(not required).
    }

    public function ownedBy(User $user)
    {
        return $user->id === $this->user_id;       //comparing currently authenticated user with currently clicked post. Return true if they match, return false if they don't match. This ownedBy() function is called in posts/index.blade.php file.
    }
}
