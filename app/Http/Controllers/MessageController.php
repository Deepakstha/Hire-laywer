<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class MessageController extends Controller
{
    // public function index()
    // {
    //     return view('chat');
    // }

    public function fetchMessages($id)
    {
        $user = Auth::user()->id;
        $receiver = User::where('id', $id)->first();
        $message = DB::table('messages')->where('sender', $id)->where('receiver', $user)->orWhere(function ($query) use ($id, $user) {
            $query->where('sender', $user)
                ->where('receiver', $id);
        })->get();
        return view('message', ['receiver' => $receiver, 'message' => $message]);
    }

    public function sendMessage(Request $request)
    {

        $user = Auth::user()->id;
        Message::create(['sender' => $user, 'receiver' => $request->receiver, 'message' => $request->message, 'chatUsers' => "user"]);
        return back()->with('success', 'message send');
        // return redirect("/");
    }
}
