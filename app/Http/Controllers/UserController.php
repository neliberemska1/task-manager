<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Task;

class UserController extends Controller
{
    public function getUserInfo(Request $request)
    {
        $user = Auth::user();
        $userData = $user->only(['id', 'email', 'name']);
        return response()->json($userData);
    }

    public function getAllUsers(Request $request){
        return response()->json(Auth::user()->get());
    }
}