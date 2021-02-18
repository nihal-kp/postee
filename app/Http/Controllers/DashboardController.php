<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);            //or other way is set middleware('auth') in route('dashboard')
    }
    public function index()
    {
        //dd(Auth::user());          //Returns all information of authenticated user in user object. Arrays are there inside the object.
        //dd(Auth::user()->posts);     //Returns authenticated user information, that user's posts information in an array of 'User' Model object of Collection object. User's posts information is showing inside 'User' Model object because we set hasMany relationship in 'User' model(ie., 'User' hasMany 'Post')
        return view('dashboard');
    }
}
