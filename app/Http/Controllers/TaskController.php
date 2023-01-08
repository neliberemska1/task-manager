<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    public function getTasks(Request $request)
    {
        return response()->json(Task::latest()->get());
    }

    public function getUserTasks(Request $request, $userId)
    {
        $user = User::find($userId);
        $userName = $user->name;
        $tasks = Task::where('assignee', $userName)->latest()->get();
        return response()->json($tasks);
    }
    

    public function getUserInfo(Request $request)
    {
        $user = Auth::user();
        $userData = $user->only(['id', 'email', 'name']);
        return response()->json($userData);
    }

    public function getUsers(Request $request){
        return response()->json(Auth::user()->get());
    }

    public function addTask(Request $request)
    {
        Task::create([
            'title'     => $request->title,
            'date'      => $request->date,
            'assignee'  => $request->assignee,
            'reporter'  => $request->reporter,
            'points'    => $request->points,
            'status'    => $request->status,
            'details'   => $request->details
        ]);

        return response()->json('Task added successfully!');
    }

    public function updateTask(Request $request, $id)
    {
        Task::where('id', $id)->update([
            'title'     => $request->title,
            'date'      => $request->date,
            'assignee'  => $request->assignee,
            'reporter'  => $request->reporter,
            'points'    => $request->points,
            'status'    => $request->status,
            'details'   => $request->details
        ]);

        return response()->json('Task updated successfully!');
    }

    public function deleteTask($id)
    {
        Task::where('id', $id)->delete();
        return response()->json('Task deleted successfully!');
    }
}