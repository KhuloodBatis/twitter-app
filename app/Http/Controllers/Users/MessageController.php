<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Message\MessageResource;
use App\Notifications\Messages\MessagesNotification;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        //Ali way
        // $messages = Message::where('sender_id', Auth::id())
        //     ->orWhere('receiver_id', Auth::id())
        //     //->paginate(4);
        //        ->get()
        //        ->sortBy('created_at')
        //        ->groupBy(function ($message) {
        //      $message->sender_id === Auth::id() ?
        //         $message->receiver_id : $message->sender_id;
        //          });
        // return $messages;
        //return MessageResource::collection($messages);
        //kool way
        // $messages = Message::Where('sender_id', Auth::id())
        //     ->orWhere('receiver_id', Auth::id())
        //     ->orderBy('created_at', 'desc', 'sender_id')
        //     ->get(['sender_id', 'receiver_id', 'body', 'created_at'])
        //      ->groupBy(function ($message) {
        //     $message->sender_id === Auth::id() ?
        //         $message->receiver_id : $message->sender_id;
        // });

        //Ahmad way
        $messages = Message::fromSub(
            Message::select(
                DB::raw('MAX(id) as max_id, IF(`receiver_id` = ' . Auth::id() . ', `sender_id`, `receiver_id`) AS user_id')
            )
                ->where('receiver_id', Auth::id())
                ->groupBy('user_id'),
            'm1'
        )
            ->leftJoin('messages as m2', 'm2.id', '=', 'm1.max_id')
            ->get();
        //  SELECT * FROM
        //       (
        // 	SELECT MAX(id) AS max_id, IF(receiver_id = 1, sender_id, receiver_id) AS user_id
        // 	FROM messages
        // 	WHERE receiver_id = 1
        // 	GROUP BY user_id
        //       ) AS m1
        //  LEFT JOIN messages m2 ON m2.id = m1.max_id

        return $messages;
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
