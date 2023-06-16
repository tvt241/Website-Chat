<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Http\Resources\UserAndMessageLatestResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        // $users = User::query()
        //     ->where('id', '<>', auth()->id())
        //     ->with(["messages", "messagesTo"])
        //     ->get();
        // $data = UserAndMessageLatestResource::collection($users);
        // return 0;
        $users = User::query()
            ->join('messages')
            ->orderBy('messages.created_at', 'DESC')
            ->select('users.*')
            ->distinct()
            ->get();
        return 0;
    }
}
