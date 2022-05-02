<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Message\MessageResource;
use App\Notifications\Messages\MessagesNotification;

class MessageController extends Controller
{
    public function index()
    {

        $messages = Message::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->paginate(4);
        // ->get()
        // ->sortBy('created_at')
        // ->groupBy(function ($message) {
        //     $message->sender_id === Auth::id() ?
        //         $message->receiver_id : $message->sender_id;
        // });
        return MessageResource::collection($messages);
    }
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
            'receiver_id' => ['required', 'exists:users,id']
        ]);

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'body' => $request->body,
            'receiver_id' => $request->receiver_id
        ]);

        //to prevent the send notification for userself
        // if ($request->user()->id !== $message->sender_id) {
        //     //to send notification when user do like to nothe user then the firest have notification
        //     $message->user()->notify(new MessagesNotification($request->user(), $message));
        // }

        return response()->json([

            'status' => 'Message was sended',
            'data' => new MessageResource($message)
        ]);
    }
    public function destroy($message)
    {
        $message = Message::where('id', $message)->delete();
        return response()->json(['status' => 'Message was deleted']);
    }
}
