<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAndMessageLatestResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->where("id", "<>", auth()->id())
            // ->with(["messages", "messagesTo"])
            ->get();
        return response()->json([
            "status" => true,
            "data" => UserAndMessageLatestResource::collection($users)
        ]);
    }
}
